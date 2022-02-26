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

use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlayerApi extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    public function getAll(Player $player)
    {
        return  $player->all();
    }
    /**
     * Operation addplayer
     *
     * Add a new player to the store.
     *
     * @return \Illuminate\Http\JsonResponse Array with Player ID
     */
    public function addPlayer(Request $request)
    {
        $nickname = $request->input('nickname');
        $status = 1;
        $ranking = $request->input('ranking',0);;
        $avatar = $request->file('avatar');

        // Unique check on nickname
        if ($nickname === null) {
            return response()->json([
                'error' => 'Bad Request',
                'message' => 'Missing mandatory nickname',
                'response' => 400
            ]);
        }

        if ($avatar) {
            Storage::put($avatar->getClientOriginalName(), $avatar);
        }

        $player = new Player();
        $player->id = Str::uuid()->toString();
        $player->nickname = $nickname;
        $player->status = $status;
        $player->ranking = $ranking;
        $player->avatar = $avatar->getClientOriginalName();
        $player->save();

        return [
            'response' => 200,
            'message' => $player->id
        ];
    }

    /**
     * Operation updateplayer
     *
     * Update an existing player.
     *
     *
     * @return Http response
     */
    public function updatePlayer(Request $request)
    {
        $id = $request->input('id');
        $playerOld = $this->getPlayerById($id);

        if($playerOld['error']) {
            return $playerOld;
        }

        $player = new Player();
        $nickname = $request->input('nickname',$playerOld->nickname);
        $status = $request->input('status',$playerOld->status);
        $ranking = $request->input('ranking',$playerOld->ranking);;
        $avatar = $request->file('avatar');

        if ($avatar) {
            Storage::put($avatar->getClientOriginalName(), $avatar);
            $player->avatar = $avatar->getClientOriginalName();
        } else {
            $player->avatar = $playerOld->avatar;
        }

        $player->id = $id;
        $player->nickname = $nickname;
        $player->status = $status;
        $player->ranking = $ranking;
        $player->update();

        return [
            'response' => 200,
            'message' => $player->id
        ];
    }
    /**
     * Operation findplayersByStatus
     *
     * Finds players by status.
     *
     *
     * @return Http response
     */
    public function findplayersByStatus()
    {
        $input = Request::all();

        //path params validation


        //not path params validation
        if (!isset($input['status'])) {
            throw new \InvalidArgumentException('Missing the required parameter $status when calling findplayersByStatus');
        }
        $status = $input['status'];


        return response('How about implementing findplayersByStatus as a get method ?');
    }
    /**
     * Operation findplayersByTags
     *
     * Finds players by tags.
     *
     *
     * @return Http response
     */
    public function findplayersByTags()
    {
        $input = Request::all();

        //path params validation


        //not path params validation
        if (!isset($input['tags'])) {
            throw new \InvalidArgumentException('Missing the required parameter $tags when calling findplayersByTags');
        }
        $tags = $input['tags'];


        return response('How about implementing findplayersByTags as a get method ?');
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
    public function deletePlayer($playerId)
    {
        $playerModel = new Player();
        $player = $playerModel->find($playerId);
        if($player){
            $player->delete();
            return [
                'message' => 'Player deleted'
            ];
        } else {
            return [
                'error' => 'Not Found',
                'message' => 'Player not found',
                'response' => 404
            ];
        }
    }
    /**
     * Operation getplayerById
     *
     * Find player by ID.
     *
     * @param int $player_id ID of player to return (required)
     *
     * @return array If exists object with player data
     */
    public function getPlayerById($playerId)
    {
        $res = ['error' => 'Bad Request'];
        if ($playerId) {
            $modelPlayer = new Player();
            $player = $modelPlayer->find($playerId);
            if ($player) {
                $res = $player;
            } else {
                $res['message'] = 'Player not found';
            }
        } else {
            $res['message'] = 'ID not sent';
        }
        return $res;
    }
    /**
     * Operation updateplayerWithForm
     *
     * Updates a player in the store with form data.
     *
     * @param int $player_id ID of player that needs to be updated (required)
     *
     * @return Http response
     */
    public function updateplayerWithForm($player_id)
    {
        $input = Request::all();

        //path params validation


        //not path params validation

        return response('How about implementing updateplayerWithForm as a post method ?');
    }
    /**
     * Operation uploadFile
     *
     * uploads an image.
     *
     * @param int $player_id ID of player to update (required)
     *
     * @return Http response
     */
    public function uploadFile($player_id)
    {
        $input = Request::all();

        //path params validation


        //not path params validation

        return response('How about implementing uploadFile as a post method ?');
    }
}
