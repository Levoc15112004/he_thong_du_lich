<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserVoucher extends Pivot
{
    protected $table = 'user_vouchers';

    protected $fillable = ['user_id', 'voucher_id', 'status', 'used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
