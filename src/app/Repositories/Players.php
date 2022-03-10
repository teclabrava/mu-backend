<?php

namespace App\Repositories;

use App\Models\Player;

class Players
{
    public function search()
    {
        $q = request('q', null);
        $last_id = request('last', null);
        $per_page = request('per_page', 10);
        $player = new Player();

        $query = $player->newQuery();

        if ($last_id && $last=Player::find($last_id)) {
            $query=$query->after($last);
        }

        if ($q != null && $q != "") {
            $query=$query->where('id', 'contains',$q )
                ->orWhere('nickname', 'contains', $q)
                ->orWhere('status', 'contains', $q)
                ->orWhere('ranking', 'contains', $q);
        }

        $total_count = $query->count();
        $query=$query->limit($per_page);
        $items = $query->get();
        $page_count =$query->count();
        $last = $items->last();

        $paramerter_q = ($q == null) ? "" : "q=$q";
        $paramerter_per_page = ($per_page == 10) ? "" : "&per_page=$per_page";
        $next_link = ($last) ? "player?$paramerter_q$paramerter_per_page&last={$last->id}" : "";
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
        $player= new Player();
        $player = $player->newQuery()->find($id);
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
