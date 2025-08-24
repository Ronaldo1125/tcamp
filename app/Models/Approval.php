<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_order_id',
        'approval_type_id',
        'user_id',
        'remarks',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
