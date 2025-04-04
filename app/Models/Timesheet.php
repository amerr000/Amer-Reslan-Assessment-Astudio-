<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'task_name',
        'date',
        'hours'
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
