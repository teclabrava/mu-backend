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

use App\Repositories\Players;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Player;


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
        $players = $this->players->search();
        return new JsonResponse($players,206);
    }

    /**
     * Operation addplayer
     *
     * Add a new player to the store.
     *
     * @return \Illuminate\Http\JsonResponse Array with Player ID
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required|max:255',
            'status' => 'required|max:10',
            'ranking' => 'required|integer',
            'avatar' =>  'required',
        ]);

        $player = $this->players->store($request);
        return response()->json($player,201 );
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nickname' => 'required|max:255',
            'status' => 'required|max:10',
            'ranking' => 'required|integer',
            'avatar' =>  'required',
        ]);
        $player = $this->players->update($request, $id);
        if($player) {
            return response()->json($player, 200);
        } else {
            return response()->json(null, 422);
        }
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
        if ($this->players->destroy($id)) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 404);
        }
    }

}
