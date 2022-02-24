<?php

namespace App\Models;

use BaoPham\DynamoDb\DynamoDbModel as ModelBase;

class Model extends ModelBase
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nickname', 'status', 'ranking', 'avatar'
    ];

    public function getTable()
    {
        return env('DB_PREFIX','local') .'.'.  $this->table;
    }
}
