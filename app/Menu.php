<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'price', 'image', 'description', 'category_id'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
