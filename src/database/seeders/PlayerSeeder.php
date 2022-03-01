<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use BaoPham\DynamoDb\Facades\DynamoDb;

class PlayerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Player::factory()
            ->connection(config('dynamodb.default'))
            ->count(800)
            ->create();
    }
}
