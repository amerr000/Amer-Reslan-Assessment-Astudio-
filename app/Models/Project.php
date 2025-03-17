<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TimeSheet;
use App\Models\AttributeValue;
use App\Models\Attribute;


class Project extends Model
{
    use HasFactory;

protected $fillable = [
        'name',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timeSheets()
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function attributes()
{
    return $this->hasManyThrough(
        Attribute::class,
        AttributeValue::class,
        'project_id',
        'id',
        'id',
        'attribute_id'
    );
}

}
