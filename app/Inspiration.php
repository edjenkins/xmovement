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
		'description',
		'content',
    ];

    protected $dates = ['deleted_at'];

	use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
