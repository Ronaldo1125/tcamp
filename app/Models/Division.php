<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['division_name', 'division_acronym'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['division_name', 'division_acronym']);
    }

    public function users()
    {
        $this->hasMany(User::class('division_id', 'id'));
    }
}
