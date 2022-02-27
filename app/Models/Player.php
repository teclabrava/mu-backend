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
    public function __construct(array $attributes = [])
    {
        $this->table = env('DYNAMODB_PREFIX','local') . '.player';
        parent::__construct($attributes);
    }
}
