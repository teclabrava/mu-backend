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
        $last_id = request('last', null);
        $per_page = 10;
        $player = new Player();
        $query = new DynamoDbQueryBuilder($player);
        // $query = $player->newQuery();

        if ($last_id && Str::isUuid($last_id)) {
            $player = Player::where('id', '=', $last_id)->first();
            if ($player) {
               // $query = $query->withIndex('rankingIndex');
                $query = $query->afterKey(['id' => $last_id]);
            }
        }
        //$query = $query->withIndex('rankingIndex');
        $query = $query->decorate(function (RawDynamoDbQuery $raw) {
            // desc order
            $raw->query['ScanIndexForward'] = true;
        });
        $total_count = $query->count();
        if ($q != null && $q != "") {
            $query = $query->orWhere('id', 'contains', $q)
                ->orWhere('nickname', 'contains', $q)
                ->orWhere('status', 'contains', $q)->limit($per_page);
            if (is_numeric($q)) {
                $query = $query->orWhere('ranking', '=', (int)$q)->limit($per_page);
            }

        }


       // $query = $query->limit($per_page);
        $items = $query->get();
        $page_count = $items->count();
        $last = $items->last();
        $paramerter_q = ($q == null || $q == '') ? "" : "q=$q";
        $next_link = ($last) ? "player?$paramerter_q&last={$last->id}" : "";
        if ($page_count < $per_page) {
            $next_link = null;
        }

        $data = [
            "last" => ($last) ? $last->id : null,
            "per_page" => $per_page,
            "page_count" => $page_count,
            "total_count" => $total_count,
            "records" => $items,
            "links" => [
                "first" => "player?$paramerter_q",
                "self" => "player?$paramerter_q&last={$last_id}",
                "next" => $next_link,
            ]
        ];

        return $data;
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
