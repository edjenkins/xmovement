<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspirationFavourite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'inspiration_id', 'value'
    ];
}
