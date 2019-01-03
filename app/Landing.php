<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    protected $fillable = ['title', 'click'];
    protected $casts = [
        'buttons' => 'array',
    ];
}
