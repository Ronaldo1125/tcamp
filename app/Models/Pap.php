<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pap extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['pap_name', 'fund_source_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['pap_name', 'fund_source_id']);
    }

    public function travel_order()
    {
        $this->hasMany(TravelOrder::class);
    }
}
