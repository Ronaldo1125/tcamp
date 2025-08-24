<?php

namespace App\Models;

use App\Models\TravelOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ApprovalType extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'approval_type_name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['approval_type_name']);
    }

    public function travel_order()
    {
        return $this->belongsToMany(TravelOrder::class);
    }

    public function travel_order_user_approvals()
    {
        return $this->hasMany(TravelOrderUserApproval::class);
    }

}
