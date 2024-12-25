<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'color', 'size', 'stock', 'right_img', 'left_img', 'front_img', 'back_img', 'price'];

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
    public function prod_detail()
    {
        return $this->hasMany(cart::class, 'product_id', 'id');
    }
    public function customizations()
    {
        return $this->hasMany(customizedProd::class, 'product_id', 'id');
    }
}
