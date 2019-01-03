<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exmocoin extends Model
{
    protected $fillable = ['coin', 'min_price', 'max_price', 'created_at'];
}
