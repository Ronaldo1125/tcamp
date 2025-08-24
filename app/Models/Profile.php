<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['mobile_no', 'address'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['esignature', 'mobile_no', 'address','picture']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


