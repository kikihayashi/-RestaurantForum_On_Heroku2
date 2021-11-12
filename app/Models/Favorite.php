<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $table = "favorites"; //等於sql server Table名稱

    protected $cast = [
        'toppings' => 'array',
    ];
}