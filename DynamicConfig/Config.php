<?php

namespace DynamicConfig;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	protected $fillable = [
	   'key',
	   'value',
	   'type',
	];
}
