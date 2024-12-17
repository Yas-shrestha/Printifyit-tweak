<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'img_id'];
    public function image()
    {
        return  $this->belongsTo(File::class, 'img_id', 'id');
    }
}
