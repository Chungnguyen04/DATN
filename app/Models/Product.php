<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ một-nhiều với bảng variants
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    
    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id'); // Giả sử 'order_id' là khóa ngoại trong bảng order_details
    }
    public function orderDetailsTotal()
    {
        return $this->hasManyThrough(OrderDetail::class, Variant::class, 'product_id', 'variant_id');
    }
}
