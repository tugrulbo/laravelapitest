<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE users");

        DB::table("users")->insert([
            'name' => "admin",
            'email' => "admin@laravel.test",
            'email_verified_at' => now(),
            'password' => bcrypt(123), // password
            'remember_token' => Str::random(10),
        ]);

        factory(App\User::Class,10)->create();
    }
}
