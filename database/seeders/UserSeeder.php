<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Amer',
            'last_name' => 'Reslan',
            'email' => 'amerreslan13@gmail.com',
            'password' => Hash::make('1234'),
        ]);

        User::create([
            'first_name' => 'jawdat',
            'last_name' => 'reslan',
            'email' => 'jawatreslan@gmail.com',
            'password' => Hash::make('5678'),
        ]);
    }
}
