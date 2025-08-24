<?php

namespace App\Models;


use App\Models\User;
use App\Models\Designation;
use App\Models\TravelOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'user_id',
        'division_id',
        'designation_id',
        'esignature_filename',
        'created_by_id'
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
