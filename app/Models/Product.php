<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'img', 'suggestion', 'color', 'size', 'product_status', 'user_id', 'share_status',  'req_status'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Orders::class, 'product_id', 'id');
    }
    public function payment()
    {
        return $this->hasMany(Payments::class, 'product_id', 'id');
    }
    public function cart()
    {
        return $this->hasMany(cart::class, 'product_id', 'id');
    }
}
