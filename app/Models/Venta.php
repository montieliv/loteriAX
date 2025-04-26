<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'id_lottery',
        'number_card',
        'buyer_name'
    ];
}
