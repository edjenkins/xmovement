<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
		'label',
		'url',
		'idea_id',
		'data',
    ];

    protected $dates = ['deleted_at'];
}
