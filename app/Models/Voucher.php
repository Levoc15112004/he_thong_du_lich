<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'discount_type', 'discount_value', 
        'max_discount', 'min_order_value', 'event_type', 'quantity', 
        'used_count', 'start_date', 'end_date', 'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vouchers')->withPivot('status', 'used_at')->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
