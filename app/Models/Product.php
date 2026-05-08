<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'qty',
        'price',
        'image'
    ];

    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reservations(){
         return $this->hasMany(Reservation::class);
    }

    public function reservationItems()
{
    return $this->hasMany(ReservationItem::class);
}



}