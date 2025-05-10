<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'email' => 'pemilik@gmail.com',
                'password' => bcrypt('12345'),
                'level' => 'pemilik',
            ],

        
        $userData = 
        [
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'level' => 'admin',
        ],

        $userData = 
        [
            'email' => 'bendahara@gmail.com',
            'password' => bcrypt('12345'),
            'level' => 'bendahara',
        ],
    ];

    foreach($userData as $key => $val){
        User::create($val);
    }

        
    }
}
