<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'fisrt_name'           => 'Hashir',
                'email'          => 'hello@micheltanga.com',
                'password'       => bcrypt('123456'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'fisrt_name'           => 'Elvis Konye',
                'email'          => 'elvisnk620@gmail.com',
                'password'       => bcrypt('123456'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
