<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Admin',
            'email'=>'admin@mail.com',
            'password'=>bcrypt('password'),
            'photo_id'=>1,
            'role_id'=>1,
            'is_active'=>1
        ]);
    }
}
