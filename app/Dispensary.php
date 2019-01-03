<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispensary extends Model
{
    protected $fillable = ['content'];

    public function getContentAttribute($value)
    {
        return json_decode($value);
    }
}
