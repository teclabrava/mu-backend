<?php

namespace App\Models;

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

    protected $table = 'local.player';
}
