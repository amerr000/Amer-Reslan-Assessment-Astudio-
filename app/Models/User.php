<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\TimeSheet;
use App\Models\Project;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

  
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

 



    public function timeSheets()
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
