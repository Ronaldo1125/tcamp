<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transportation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['transportation_name'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['transportation_name']);
    }

    public function travel_itineraries()
    {
        $this->hasMany(TravelItinerary::class);
    }
}
