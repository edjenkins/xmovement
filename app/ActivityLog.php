<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'request',
		'response',
		'data',
		'method',
		'path',
		'url',
		'full_url',
		'action',
		'parameters',
		'ip',
		'referer',
		'user_agent',
    ];
}
