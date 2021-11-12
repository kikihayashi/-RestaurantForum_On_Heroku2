<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // use HasFactory;
    public $table = "categories"; //等於sql server Table名稱

    protected $cast = [
        'toppings' => 'array',
    ];
}