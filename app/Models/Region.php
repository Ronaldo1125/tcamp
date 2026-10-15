<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'region_code'];

    public function travel_orders() 
    {
        return $this->hasOne(TravelOrder::class, 'region_code', 'region_code');
    }
}
