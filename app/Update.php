<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
	protected $fillable = [
	   'user_id',
	   'updateable_type',
	   'updateable_id',
	   'text',
	];

    public function updateable()
    {
        return $this->morphTo();
    }

    // public function idea()
    // {
    //     return $this->belongsTo(Idea::class, 'updateable_id');
    // }
}
