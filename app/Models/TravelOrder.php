<?php

namespace App\Models;

use App\Models\ApprovalType;
use App\Models\FundSource;
use App\Models\Pap;
use App\Models\TravelItinerary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TravelOrder extends Model
{
    use HasFactory, LogsActivity, Notifiable;

    protected $fillable = [
        'to_code',
        'purpose',
        'purpose_image_filename',
        'user_id',
        'destination',
        'travel_departure_date',
        'travel_arrival_date',
        'fund_source_id',
        'pap_id',
        'other_pap_name',
        'is_travel_related_to_training',
        'is_cash_advance',
        'immediate_supervisor_id',
        'management_id',
        'budget_officer_id',
        'status',
        'remarks',
        'immediate_supervisor_approved_at',
        'management_approved_at',
        'budget_officer_approved_at',
        'grand_total',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['purpose', 'destination','travel_departure_date', 'travel_arrival_date' ]);
    }

    public function travel_itinineraries()
    {
        return $this->hasMany(TravelItinerary::class);
    }

    public function pap() {
        return $this->belongsTo(Pap::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function approval_type()
    {
        return $this->belongsToMany(ApprovalType::class, 'travel_order_user_approval');    
    }

    public function fund_source() {
        return $this->belongsTo(FundSource::class);
    }

    public function travel_order_user_approvals(){
        return $this->hasMany(TravelOrderUserApproval::class);
    }


    // The assigned Unit Head
    public function immediateSupervisor() {
        return $this->belongsTo(User::class, 'immediate_supervisor_id');
    }

    // The assigned Supervisor
    public function management() {
        return $this->belongsTo(User::class, 'management_id');
    }

    // The assigned Director
    public function budgetOfficer() {
        return $this->belongsTo(User::class, 'budget_officer_id');
    }
}
