<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            [
                'user_id' => 1,
                'club_role_id' => 1,
                'name' => 'おいちゃん'
            ],
            [
                'user_id' => 2,
                'club_role_id' => 11,
                'name' => 'おいちゃん'
            ],
            [
                'user_id' => 3,
                'club_role_id' => 11,
                'name' => 'おいちゃん'
            ],
            [
                'user_id' => 4,
                'club_role_id' => 11,
                'name' => 'おいちゃん'
            ],
            [
                'user_id' => 5,
                'club_role_id' => 21,
                'name' => 'おいちゃん'
            ],
            [
                'user_id' => 6,
                'club_role_id' => 2,
                'name' => null
            ],
            [
                'user_id' => 1,
                'club_role_id' => 12,
                'name' => null
            ],
            [
                'user_id' => 2,
                'club_role_id' => 12,
                'name' => null
            ],
        ]);
    }
}
