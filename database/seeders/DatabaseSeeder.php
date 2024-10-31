<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // for ($i = 1; $i < 10; $i++) {
        //     User::create([
        //         'name' => 'Vương'.$i,
        //         'email' => 'user'.$i.'@gmail.com',
        //         'password' =>Hash::make('123456')
                

        //     ]);
        // }
    }
}
