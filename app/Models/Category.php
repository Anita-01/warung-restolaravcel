<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; 
    protected $fillable = ['name', 'icon', 'subtitle'];
    public function menus() {
    return $this->hasMany(Menu::class);
    
}


public function products()
{
    return $this->hasMany(Product::class, 'category_id');
}

}
