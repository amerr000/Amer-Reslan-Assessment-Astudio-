<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create(['name' => 'Project Alpha', 'status' => 'active']);
        Project::create(['name' => 'Project Beta', 'status' => 'inactive']);
        Project::create(['name' => 'Project Gamma', 'status' => 'active']);

    }
}
