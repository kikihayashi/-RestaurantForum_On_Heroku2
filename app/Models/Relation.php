<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public $table = "interpersonal_relations"; //等於sql server Table名稱

    protected $cast = [
        'toppings' => 'array',
    ];
}