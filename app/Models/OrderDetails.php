<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    //Added the relationship with Order model
    public function checkOrders()
    {
        return $this-> hasOne('App\Models\Order');
    }
}
