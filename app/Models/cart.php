<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $fillable = ['user_id', 'quantity', 'product_id', 'customProd_id'];
    public function user()
    {
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function products()
    {
        return  $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function customizedProducts()
    {
        return $this->belongsTo(customizedProd::class, 'customProd_id', 'id');
    }
}
