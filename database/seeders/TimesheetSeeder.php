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
        Timesheet::create(['task_name' => 'Task 1', 'date' => '2024-03-01', 'hours' => 4, 'project_id' => 1, 'user_id' => 1]);
        Timesheet::create(['task_name' => 'Task 2', 'date' => '2024-03-02', 'hours' => 3, 'project_id' => 1, 'user_id' => 2]);
        Timesheet::create(['task_name' => 'Task 3', 'date' => '2024-03-03', 'hours' => 5, 'project_id' => 2, 'user_id' => 1]);
        Timesheet::create(['task_name' => 'Task 4', 'date' => '2024-03-04', 'hours' => 2, 'project_id' => 3, 'user_id' => 2]);
        Timesheet::create(['task_name' => 'Task 5', 'date' => '2024-03-05', 'hours' => 6, 'project_id' => 2, 'user_id' => 1]);
    }
}
