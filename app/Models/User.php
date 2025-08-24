<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Employee;
use App\Models\TravelOrder;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'division_id',
        'designation_id',
        'role_id',
        'is_active',
        'created_by_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['name', 'email', 'division_id', 'designation_id']);
    }


    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function approval_type()
    {
        return $this->belongsToMany(ApprovalType::class, 'travel_order_user_approval');
    }

    public function travel_order() 
    {
        return $this->hasMany(TravelOrder::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function travel_order_user_approval()
    {
        return $this->hasOne(TravelOrderUserApproval::class);
    }
}
