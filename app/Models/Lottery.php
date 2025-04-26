<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'order_cards',
        'cost_cards',
        'prize_cards',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
