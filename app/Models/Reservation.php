<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{

protected $fillable = [
    'name',
    'email',
    'reservation_date',
    'total_price',
    'queue_number',
    'status'

];


       public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

}
