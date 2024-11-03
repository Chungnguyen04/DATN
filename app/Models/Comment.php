<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $guarded = [];
    public function User (){
        return $this->belongsTo(User::class);
    }
    public  function Order(){
        return $this->belongsTo(Order::class);
    }
    public function Product(){
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}