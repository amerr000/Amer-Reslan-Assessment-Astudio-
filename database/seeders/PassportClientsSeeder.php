<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;


class PassportClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             // Create Personal Access Client
             $personalClient = Client::create([
                'name' => 'Laravel Personal Access Client',
                'secret' => \Str::random(40), // Generate a random secure secret
                'redirect' => 'http://localhost',
                'personal_access_client' => true,
                'password_client' => false,
                'revoked' => false,
            ]);
    
            // Create Password Grant Client
            $passwordClient = Client::create([
                'name' => 'Laravel Password Grant Client',
                'secret' => \Str::random(40), // Generate a random secure secret
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]);
    
            // Link the personal client in oauth_personal_access_clients
            \DB::table('oauth_personal_access_clients')->insert([
                'client_id' => $personalClient->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
