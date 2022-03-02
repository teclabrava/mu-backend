<?php

namespace App\Repositories;

use App\Models\Player;
use BaoPham\DynamoDb\RawDynamoDbQuery;

class Players
{
    public function search()
    {
        $q = request('q', null);
        $last_id = request('last', null);
        $per_page = request('per_page', 10);

        $query = Player::query();
        if ($last_id) {
            $query->after(Player::findOrFail($last_id));
        }

        if ($q != null && $q != "") {
            $query->where('id', 'contains', $q)
                ->orWhere('nickname', 'contains', $q)
                ->orWhere('status', 'contains', $q);
            if(is_numeric($q) && is_int($q +0)) {
                $query->orWhere('id', '=', $q);
            }
        }

        $total_count = $query->count();
        $query->limit($per_page);
        $page_count = $query->count();
        $items = $query->all();
        $last = $items->last();
        $paramerter_q = ($q == null) ? "" : "q=$q";
        $paramerter_per_page = ($per_page == 10) ? "" : "&per_page=$per_page";
        $next_link = ($last)? "player?$paramerter_q$paramerter_per_page&last={$last->id}": "" ;
        if ($page_count < $per_page) {
            $next_link = null;
        }
        $data = [
            "last" =>  ($last)? $last->id: null,
            "per_page" => $per_page,
            "page_count" => $page_count,
            "total_count" => $total_count,
            "records" => $items,
            "links" => [
                "first" => "player?$paramerter_q$paramerter_per_page",
                "self" => "player?$paramerter_q$paramerter_per_page&last={$last_id}",
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
        return Player::find($id);
    }

    public function update($request, $id)
    {
        $player = $this->findById($id);
        if ($player) {
            $player->update($request->all());
            $player->addAvatar($request["avatar"]);
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
