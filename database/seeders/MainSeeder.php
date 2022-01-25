<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "profile_id" => 1,
            "name" => "Main user",
            "email" => "main@user.com",
            "password" => Hash::make("main@user.com"),
            "api_token" => Str::random(60),
            "status" => 1
        ]);
    }
}
