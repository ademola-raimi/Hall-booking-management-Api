<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model implements
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'password', 'description', 'address', 'area', 'state', 'price', 'image'
    ];

    /**
     * Hall belongs to user.
     *
     * @return Object
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
