<?php

namespace App\Models;

use App\Models\ApprovalType;
use App\Models\FundSource;
use App\Models\Pap;
use App\Models\TravelItinerary;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TravelOrder extends Model
{
    use HasFactory, LogsActivity, Notifiable;

    protected $fillable = [
        'purpose',
        'purpose_image_filename',
        'region_code',
        'province_code',
        'city_code',
        'user_id',
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

    public function scopeForUser(Builder $query, User $user): Builder
    {
        // 1. Admin: Display everything (no filtering)
        if ($user->hasAnyRole(['Admin', 'Budget Officer', 'Management'])) {
            return $query;
        }

        // 2. Division Chief: Display inputs from users in their division
        if ($user->hasRole('Immediate Supervisor')) {
            return $query->whereHas('user', function ($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        }

        // 3. Regular User: Display only their own inputs
        return $query->where('user_id', $user->id);
    }

    protected static function booted()
    {
        static::creating(function ($travelOrder) {

            $dateString = now()->format('Ymd');
            $prefix = 'TO-' . $dateString . '-';

            $nextSequenceNumber = DB::transaction(function () use ($prefix) {
                $lastTravelOrder = TravelOrder::where('to_code', 'like', $prefix . '%')
                    ->lockForUpdate()
                    ->latest('id')
                    ->first();
                    
                if ($lastTravelOrder) {
                    $lastSequenceNumber = (int) substr($lastTravelOrder->to_code, strrpos($lastTravelOrder->to_code, '-') + 1);
                    return $lastSequenceNumber + 1;
                }

                return 1;
            });
            
            $paddedSequenceNumber = str_pad($nextSequenceNumber, 3, '0', STR_PAD_LEFT);
            $travelOrder->to_code = $prefix . $paddedSequenceNumber;
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['purpose','travel_departure_date', 'travel_arrival_date' ]);
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
}
