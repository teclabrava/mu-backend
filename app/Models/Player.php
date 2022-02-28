<?php

namespace App\Models;

use App\Traits\HasAvatar;
class Player extends Model
{
    use HasAvatar;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nickname', 'status', 'ranking', 'avatar','avatar_pretty'
    ];
    protected $appends = ['avatar_url', 'avatar_thumb_url'];

    public function __construct(array $attributes = [])
    {
        $this->table = env('DYNAMODB_PREFIX','local') . '.player';
        parent::__construct($attributes);
    }
}
