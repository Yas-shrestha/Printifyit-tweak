<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = ['transaction_code', 'amount', 'quantity', 'product_id', 'user_id', 'customProd_id', 'color', 'size'];
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
