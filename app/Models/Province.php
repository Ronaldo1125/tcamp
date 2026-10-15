<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'province_code', 'region_code'];

    public function travel_orders()
    {
        return $this->hasOne(TravelOrder::class, 'province_code', 'province_code');
    }
}
