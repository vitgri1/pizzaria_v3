<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['base', 'name'];
    public $timestamps = false;
    protected $casts = [
        'toppings' => 'array',
    ];

    const BASES = [
        'small' => 8, 
        'medium' => 10, 
        'large' => 12
    ];

    const TOPPINGS = [
        1 => 'extra cheese',
        2 => 'chicken',
        3 => 'ham',
        4 => 'pepreroni',
        5 => 'bacon',
        6 => 'beef',
        7 => 'mince',
        8 => 'prosciutto',
        9 => 'salami',
        10 => 'anchovies',
        11 => 'wurstel',
        12 => 'BBQ sauce',
        13 => 'pesto sauce',
        14 => 'onion',
        15 => 'chilli',
        16 => 'kale',
        17 => 'capsicum',
        18 => 'pineapple',
        19 => 'olives',
        20 => 'spinach',
        21 => 'fried chips',
        22 => 'mushrooms'
    ];
}
