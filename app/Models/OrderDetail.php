<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'order_id','id'); // 'order_id' là khóa ngoại trong bảng order_details
    }
}
