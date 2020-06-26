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
        //
        $id = DB::table('users')->insertGetId([
            'name'      =>  'Dennis Kiptoo Kiptugen',
            'username'  =>  'caydee',
            'email'     =>  'caydee209@gmail.com',
            'password'  =>  bcrypt('secret'),
            'status'    =>  true,

        ]);
        DB::table('user_roles')->insert([
            'user_id'       =>  $id,
            'access_name'   =>  'users',
            'access_value'  =>  serialize(['add','update','delete'])
        ]);


    }
}
