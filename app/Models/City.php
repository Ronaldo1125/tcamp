<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_code', 'province_code', 'region_code'];

    public function travel_orders()
    {
        return $this->hasOne(TravelOrder::class, 'city_code', 'city_code');
    }
    
}
