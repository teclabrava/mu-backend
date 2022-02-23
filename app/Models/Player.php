<?php

namespace App\Models;

use BaoPham\DynamoDb\DynamoDbModel as Model;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nickname', 'status', 'ranking', 'avatar'
    ];

    protected $table = 'player';
}
