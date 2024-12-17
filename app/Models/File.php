<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['title', 'img'];
    public function Category()
    {
        return  $this->hasMany(Category::class, 'img', 'id');
    }
}
