<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TravelOrderUserApproval extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'travel_order_user_approval';

    protected $fillable = ['user_id', 'travel_order_id', 'approval_type_id', 'remarks'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['user_id', 'travel_order_id','approval_type_id', 'remarks' ]);
    }

    public function travel_order() 
    {
        return $this->belongsTo(TravelOrder::class);    
    }

    public function approval_type() {
        return $this->belongsTo(ApprovalType::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
