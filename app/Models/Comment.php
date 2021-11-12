<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // use HasFactory;
    public $table = "comments"; //等於sql server Table名稱

    protected $cast = [
        'toppings' => 'array',
    ];
}