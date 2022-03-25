<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //Added the relationship with OrderDetails and User model
    public function getOrderDetails()
    {
        return $this-> hasMany('App\Models\OrderDetails');
    }

    public function getUser()
    {
        return $this-> hasOne('App\Models\User');
    }
}
