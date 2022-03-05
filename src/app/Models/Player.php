<?php

namespace App\Models;

use App\Traits\HasAvatar;
use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory, HasAvatar, TraitUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nickname', 'status', 'ranking', 'avatar', 'avatar_pretty'
    ];

    protected $appends = ['avatar_url', 'avatar_thumb_url'];

    public function __construct(array $attributes = [])
    {
        $this->table = env('DYNAMODB_PREFIX', 'local') . '.player';
        parent::__construct($attributes);
    }
    protected $dynamoDbIndexKeys = [
        'rankingIndex' => [
            'range' => 'ranking',
            'hash' => 'id'
        ]
    ];
}
