<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['rolename'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['name']);
    }

    public function users()
    {
        return $this->hasMany(User::class('role_id', 'id'));
    }

    public function user()
    {
        return $this->hasOne(User::class('role_id', 'id'));
    }
}
