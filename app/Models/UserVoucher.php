<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    protected $table = 'user_vouchers';

    protected $guarded = [];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
