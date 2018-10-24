<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            "role_id"=>"1",
            "name"=>"adm.jaswant",
            "email"=>"admin@gmail.com",
            "password"=> bcrypt('rootadmin'),
            "username"=>"admin"
        ]);





        DB::table('users')->insert([
            "role_id"=>"2",
            "name"=>"aut.jaswant",
            "email"=>"author@gmail.com",
            "password"=> bcrypt('rootauthor'),
            "username"=>"author"
        ]);
    }




}
