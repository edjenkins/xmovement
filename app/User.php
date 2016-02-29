<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\User;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id', 'email', 'phone', 'name', 'bio', 'avatar', 'password', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The Ideas the user has created.
     *
     * @var array
     */
    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    /**
     * The Ideas the user has supported.
     *
     * @var array
     */
    public function supportedIdeas()
    {
        return $this->belongsToMany(Idea::class, 'supporters')->withTimestamps();
    }
}
