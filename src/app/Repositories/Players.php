<?php

namespace App\Repositories;

use App\Models\Player;
use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use BaoPham\DynamoDb\Facades\DynamoDb;
use BaoPham\DynamoDb\RawDynamoDbQuery;
use Illuminate\Support\Str;

class Players
{
    public function search()
    {
        $q = request('q', null);
        $page = request('page', 1);
        $limit =  request('per_page', 10);
        $player = new Player();
        $query = new DynamoDbQueryBuilder($player);

        $query = $query->decorate(function (RawDynamoDbQuery $raw) {
            // desc order
            $raw->query['ScanIndexForward'] = false;
        });

        if ($q != null && $q != "") {
            $query = $query->orWhere('id', 'contains', $q)
                ->orWhere('nickname', 'contains', $q)
                ->orWhere('status', 'contains', $q);
            if (is_numeric($q)) {
                $query = $query->orWhere('ranking', '=', (int)$q);
            }

        }

        $total = $query->count();
        $items = $query->get();
        $paramerter_q = ($q == null || $q == '') ? "" : "q=$q";


        $totalPages = ceil( $total/ $limit );
        $page = max($page, 1);
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $limit;
        if( $offset < 0 ) $offset = 0;

        $records =$items->toArray();
        usort($records, $this->sorter('ranking'));
        $records = array_slice( $records, $offset, $limit );

        $prev = ($page>1)? $page - 1:null;
        $next = ($page<$totalPages)? $page + 1:null;
        $data = [
            "per_page" => $limit,
            "page_count" => count($records),
            "total_count" => $total,
            "records" => $records,
            "links" => [
                "first" => "player?$paramerter_q",
                "prev" => ($page>1)? "player?$paramerter_q&page={$prev}": null,
                "next" => "player?$paramerter_q&prev={$next}",
                "last" => "player?$paramerter_q&page={$totalPages}",
            ]
        ];

        return $data;
    }

    function sorter($key) {
        return function ($a, $b) use ($key) {
            return (int)$a[$key]<(int)$b[$key];
        };
    }

    public function store($request)
    {
        $playerRequest = $request->all();
        $player = new Player($playerRequest);
        $player->addAvatar($playerRequest["avatar"]);
        $player->save();
        return $player;
    }

    public function findById($id)
    {
        $query = new Player();
        return $query->where('id', '=', $id)->first();;
    }

    public function update($request, $id)
    {
        $player = $this->findById($id);
        $playerRequest = $request->all();
        $avatar = $playerRequest["avatar"];
        unset($playerRequest["_method"]);
        unset($playerRequest["avatar"]);
        if ($player) {
            $player->update($playerRequest);
            if(!is_string($avatar)){
                $player->addAvatar($avatar);
            }
            $player->save();
            return $player;
        }
        return 422;

    }

    public function destroy($id)
    {
        $player = $this->findById($id);
        if ($player) {
            $player->delete();
            return 204;
        }
        return 404;
    }


}
