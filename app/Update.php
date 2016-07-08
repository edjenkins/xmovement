<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
	protected $fillable = [
	   'user_id',
	   'idea_id',
	   'text',
	];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
