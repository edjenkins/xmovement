<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspiration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'type',
		'title',
		'description',
		'content',
    ];

    protected $dates = ['deleted_at'];

	use SoftDeletes;

}
