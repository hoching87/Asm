<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bouquet extends Model
{
    use HasFactory;

    //Quantity removed
    protected $fillable = [
        'bouequetName',
        'bouequetDescription',
        'bouequetPrice',
        'bouquetimage',
        'type'
    ];
}
