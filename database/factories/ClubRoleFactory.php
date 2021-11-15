<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClubRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    private static int $sequence = 1;

    public function definition()
    {
        return [
            'club_id' => function () {
                return self::$sequence++;
            },
            'role_number' => 2,
            'role_name' => 'メンバー',
        ];
    }
}
