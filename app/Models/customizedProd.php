<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customizedProd extends Model
{
    protected $fillable = ['product_id', 'user_id', 'front_customization', 'back_customization', 'left_customization', 'right_customization', 'notes', 'status'];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
