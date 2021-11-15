<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unique_name' => $this->faker->unique()->word(),
            'name' => $this->faker->company(),
            'password' => 'password',
        ];
    }
}
