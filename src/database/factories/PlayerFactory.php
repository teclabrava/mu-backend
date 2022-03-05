<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id" => $this->faker->uuid,
            "nickname" => $this->faker->name,
            "avatar" => null,
            "avatar_external" => "https://i.pravatar.cc/150?u=" . $this->faker->uuid,
            "status" => $this->faker->randomElement(["oro", "plata", "bronce"]),
            "ranking" => "{$this->faker->numberBetween(500, 1000)}",
            "created_at" => $this->faker->dateTimeBetween("-1 month", "now", "America/Guayaquil"),
            "updated_at" => null,
        ];
    }

}
