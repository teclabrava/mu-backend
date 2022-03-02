<?php

/**
 * Mañu
 *
 * Juego desarrallado para CREDITU para mejorar el rendimiento del departamento de colocación de crédito
 *
 * OpenAPI spec version: 1.0.0
 * Contact: dev@teclabrava.com
 *
 */


namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Repositories\Players;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{

    protected $players;

    public function __construct(Players $players)
    {
        $this->players = $players;
    }
    /**
     * Get all players
     *
     * @param Player $player Player Model
     * @param Request $request Filters passed: nickname and status
     * @return \BaoPham\DynamoDb\DynamoDbCollection All players found by filter
     */
    public function index()
    {
        $players = $this->players->getPaginated();
        return $players;
    }

    /**
     * Operation addplayer
     *
     * Add a new player to the store.
     *
     * @return \Illuminate\Http\JsonResponse Array with Player ID
     */
    public function store(CreatePlayerRequest $request)
    {
        $player = $this->players->store($request);
        return $player;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $player = $this->players->findById($id);
       return $player;
    }

    /**
     * Operation updateplayer
     *
     * Update an existing player.
     *
     *
     * @return Http response
     */
    public function update(UpdatePlayerRequest $request, $id)
    {
        $player = $this->players->update($request, $id);
        return $player;
    }

    /**
     * Operation deleteplayer
     *
     * Deletes a player.
     *
     * @param int $player_id player id to delete (required)
     *
     * @return Http response
     */
    public function destroy($id)
    {
        $this->players->destroy($id);
        return response()->json(null, 204);
    }

    public function search($q)
    {
        $players = $this->players->search($q);
        return $players;
    }
}
