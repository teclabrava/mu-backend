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

/**
 * Class PlayerController - Controlador de jugadores
 */
class PlayerController extends Controller
{
    /**
     * @var Players
     */
    protected $players;
    /**
     * @var JsonResponse
     */
    protected $response;

    /**
     * @param Players $players
     * @param JsonResponse $response
     */
    public function __construct(Players $players, JsonResponse $response)
    {
        $this->players = $players;
        $this->response = $response;
    }

    /**
     * Display a listing of the playes.
     * @return \Illuminate\Http\JsonResponse All players found by filter
     */
    public function index()
    {
        $players = $this->players->search();
        $this->response->setData($players);
        $this->response->setStatusCode(206);
        return $this->response;
    }

    /**
     * Operation createPlayer
     * @param Request $request Player to create
     * @return \Illuminate\Http\JsonResponse Player added
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required|max:255',
            'status' => 'required|max:10',
            'ranking' => 'required|integer',
            'avatar' => 'required',
        ]);
        $player = $this->players->store($request);
        $this->response->setData($player);
        $this->response->setStatusCode(201);
        return $this->response;
    }

    /**
     * Display the  player.
     * @param $id Player id
     * @return \Illuminate\Http\JsonResponse Player found by id
     */
    public function show($id)
    {
        $player = $this->players->findById($id);
        $this->response->setStatusCode(404);
        if ($player) {
            $this->response->setStatusCode(200);
        }
        $this->response->setData($player);
        return $this->response;
    }

    /**
     * Operation updatePlayer
     * @param Request $request Player to update
     * @return \Illuminate\Http\JsonResponse Player updated
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nickname' => 'required|max:255',
            'status' => 'required|max:10',
            'ranking' => 'required|integer',
            'avatar' => 'required',
        ]);

        $player = $this->players->update($request, $id);
        $this->response->setStatusCode(422);
        if ($player) {
            $this->response->setStatusCode(200);
        }
        $this->response->setData($player);
        return $this->response;
    }

    /**
     * Operation deleteplayer
     * @param $id   Player id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $statusCode= $this->players->destroy($id);
        $this->response->setStatusCode($statusCode);
        $this->response->setData([]);
        return $this->response;
    }
}
