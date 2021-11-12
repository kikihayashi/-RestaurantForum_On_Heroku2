<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    // use HasFactory;
    public $table = "restaurants"; //等於sql server Table名稱

    protected $cast = [
        'toppings' => 'array',
    ];
}