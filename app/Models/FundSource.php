<?php

namespace App\Models;

use App\Models\TravelOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FundSource extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fund_sources';

    protected $fillable = ['fund_source_name','fund_source_acronym'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['fund_source_name', 'fund_source_acronym']);
    }

    public function travel_order() {
        return $this->hasMany(TravelOrder::class);
    }
}
