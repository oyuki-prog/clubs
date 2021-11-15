<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(50)->create();
        // \App\Models\Club::factory(10)->create();
        // \App\Models\Plan::factory(30)->create();
        // \App\Models\ClubRole::factory(10)->create();

        \App\Models\ClubRole::factory(10)->create();
        $this->call([
            // ClubRoleSeeder::class,
            UserRoleSeeder::class,
        ]);
    }
}
