<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'items',
        'phone',
        'adress',
        'status',
        'date_ordered',
        'date_delivered'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function getUser()
    {
        return $this->belongsTo('App\Models\User');
    }
}
