<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'provider_id', 'provider', 'access_token'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getImage()
    {
        if($this->avatar == null)
        {
            return '/img/no-image.png';
        }

        return $this->avatar;
    }

    public function getCreatedAtAttribute($value)
    {
        Carbon::setLocale('uk');

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();

        return $date;
    }
}
