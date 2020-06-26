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
        $id = DB::table('users')->insertGetId([
            'name'      =>  'Jared Kidambi',
            'username'  =>  'jkidambi',
            'email'     =>  'jkidambi@standardmedia.co.ke',
            'password'  =>  bcrypt('RK147nfnBH'),
            'status'    =>  true,

        ]);
        DB::table('user_roles')->insert([
            'user_id'       =>  $id,
            'access_name'   =>  'users',
            'access_value'  =>  serialize(['add','update','delete'])
        ]);
        $id = DB::table('users')->insertGetId([
            'name'      =>  'Patrick Onganga',
            'username'  =>  'pogangah',
            'email'     =>  'pogangah@STANDARDMEDIA.CO.KE',
            'password'  =>  bcrypt('nMbv0UQa3L'),
            'status'    =>  true,

        ]);
        DB::table('user_roles')->insert([
            'user_id'       =>  $id,
            'access_name'   =>  'users',
            'access_value'  =>  serialize(['add','update','delete'])
        ]);
        $id = DB::table('users')->insertGetId([
            'name'      =>  'Matthew Shahi',
            'username'  =>  'mshahi',
            'email'     =>  'mshahi@STANDARDMEDIA.CO.KE',
            'password'  =>  bcrypt('PhkLTOHBGC'),
            'status'    =>  true,

        ]);
        DB::table('user_roles')->insert([
            'user_id'       =>  $id,
            'access_name'   =>  'users',
            'access_value'  =>  serialize(['add','update','delete'])
        ]);


    }
}
