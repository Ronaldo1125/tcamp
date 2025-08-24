<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'region_code'];

    public function travel_itineraries() 
    {
        return $this->hasMany(TravelItinerary::class, 'region_code', 'region_code');
    }
}
