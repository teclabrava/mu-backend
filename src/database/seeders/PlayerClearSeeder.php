<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use BaoPham\DynamoDb\Facades\DynamoDb;

class PlayerClearSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Player::all()->each(function ($player) {
            $player->delete();
        });
    }
}
