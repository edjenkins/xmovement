<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $fillable = [
		'user_id',
		'reportable_id',
		'reportable_type'
	];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
