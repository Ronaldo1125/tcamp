<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Designation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['designation_name', 'designation_acronym'];

    Public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['designation_name', 'designation_acronym']);
    }

    public function users() 
    {
        return $this->hasMany(User::class, 'designation_id', 'id');
    }
    
}
