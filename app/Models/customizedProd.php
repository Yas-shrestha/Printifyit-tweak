<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customizedProd extends Model
{
    protected $fillable = ['product_id', 'user_id', 'color', 'size', 'views', 'customization_charge',  'status'];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function cart()
    {
        return $this->hasMany(cart::class, 'customProd_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Orders::class, 'customProd_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(Payments::class, 'customProd_id', 'id');
    }
}
