<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('club_roles')->insert([
            [
                'club_id' => 1,
                'role_number' => 3,
                'role_name' => '保護者会幹部'
            ]
        ]);
    }
}
