<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['user_id', 'quantity', 'price_per_item', 'color', 'size', 'product_id', 'total_amount', 'esewa_status', 'product_status', 'customProd_id'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function customizedProducts()
    {
        return $this->belongsTo(customizedProd::class, 'customProd_id', 'id');
    }
}
