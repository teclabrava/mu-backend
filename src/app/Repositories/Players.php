<?php

namespace App\Repositories;

use App\Models\Player;
use BaoPham\DynamoDb\RawDynamoDbQuery;

class Players
{

    public function getPaginated()
    {
        $page = request('page', 1);
        $per_page = request('per_page', 10);
        return Player::decorate(function (RawDynamoDbQuery $raw) {
            $raw->query['ScanIndexForward'] = false;
        })->limit($per_page)->offset(($page - 1) * $per_page)->get();
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
        return Player::findOrFail($id);
    }

    public function update($request, $id)
    {
        $player = $this->findById($id);
        $player->update($request->all());
        $player->addAvatar($request["avatar"]);
        $player->save();
        return $player;
    }

    public function destroy($id)
    {
        $player = $this->findById($id);
        $player->delete();
    }

    public function search($q)
    {
        $page = request('page', 1);
        $per_page = request('per_page', 10);
        $players = Player::where('id', 'contains', $q)
            ->orWhere('nickname', 'contains', $q)
            ->orWhere('status', 'contains', $q)
            ->decorate(function (RawDynamoDbQuery $raw) {
                $raw->query['ScanIndexForward'] = false;
            })->limit($per_page)->offset(($page - 1) * $per_page)->get();
        return $players;
    }
}
