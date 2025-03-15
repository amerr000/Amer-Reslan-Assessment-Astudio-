<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Timesheet;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timesheet::create([
            'user_id' => 1, 
            'project_id' => 1,
            'task_name' => 'Initial Research',
            'date' => now(),
            'hours' => 5,
        ]);

        Timesheet::create([
            'user_id' => 2, 
            'project_id' => 1,
            'task_name' => 'Development Phase 1',
            'date' => now(),
            'hours' => 8,
        ]);
    }
}
