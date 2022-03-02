<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class CreatePlayerRequest extends Request
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
        return [
            'nickname' => 'required|max:255',
            'status' => 'required|max:10',
            'ranking' => 'required|integer',
            'avatar' =>  'required|image',
        ];
    }
}
