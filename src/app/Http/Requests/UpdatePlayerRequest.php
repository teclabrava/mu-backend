<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class UpdatePlayerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $player = $this->route('player');
        return [
            'nickname' => 'required|max:255|unique:players,nickname,' . $player->id,
            'status' => 'required|max:10',
            'ranking' => 'required|integer',
            'avatar' =>  'required|image',
        ];
    }

}
