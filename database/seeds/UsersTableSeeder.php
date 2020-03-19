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
            'name' => 'denis',
            'email' => 'denis'.'@gmail.com',
            'password' => bcrypt('secret'),
        ]);
        
        
        
    }
}
