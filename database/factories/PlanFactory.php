<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $meeting_time = $this->faker->dateTime($min = 'now', $timezone = date_default_timezone_get());

        return [
            'club_id' => Club::inRandomOrder()->first(),
            'name' => '練習試合',
            'meeting_time' => $meeting_time,
            'dissolution_time' =>$this->faker->dateTime($max = $meeting_time, $timezone = date_default_timezone_get()),
            'place' => '○○中学校体育館',
            'remarks' => '持ち物'
        ];
    }
}
