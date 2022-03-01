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
            "avatar_pretty" =>  null,
            "avatar_url"  => null,
            "avatar_thumb_url"  => null,
            "avatar_external" => "https://i.pravatar.cc/150?u=" . $this->faker->uuid,
            "status" => $this->faker->randomElement(["oro", "plata", "bronce"]),
            "ranking" => $this->faker->numberBetween(1, 1000),
            "created_at" => $this->faker->dateTimeBetween("-2 years", "-1 years", "America/Guayaquil"),
            "updated_at" => null,
        ];
    }

}
