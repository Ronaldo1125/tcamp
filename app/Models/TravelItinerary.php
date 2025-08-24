<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelItinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_order_id',
        'itinerary_date',
        'region_code',
        'province_code',
        'city_code',
        'estimated_time_of_departure',
        'estimated_time_of_arrival',
        'transportation_id',
        'transportation_price',
        'with_lodging',
        'with_breakfast',
        'with_lunch',
        'with_snack',
        'with_incidental_expenses',
        'total',
    ];

    public function travel_order()
    {
        return $this->belongsTo(TravelOrder::class, 'travel_order_id', 'id');
    }

    public function region() 
    {
        return $this->belongsTo(Region::class, 'region_code', 'region_code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'city_code');
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }
}
