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
        DB::table('users')->insert(
            [
            'name' => 'Reza',
            'email' => 'rezabadel@hotmail.co.uk',
            'github_username' => 'Rez85',
            'password' => bcrypt('password1234'),
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Graham Campbell',
                'email' => 'graham@alt-three.com',
                'github_username' => 'GrahamCampbell',
                'password' => bcrypt('password1234'),
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Fabien Potencier',
                'email' => 'fabien@symfony.com',
                'github_username' => 'fabpot',
                'password' => bcrypt('password1234'),
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Andrew Nesbitt',
                'email' => 'andrew@nesbitt.io',
                'github_username' => 'andrew',
                'password' => bcrypt('password1234'),
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Taylor Otwell',
                'email' => 'taylor@laravel.comm',
                'github_username' => 'taylorotwell',
                'password' => bcrypt('password1234'),
            ]
        );
    }
}
