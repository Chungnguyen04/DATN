<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $guarded = [];

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class, 'voucher_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'voucher_id', 'id');
    }
}
