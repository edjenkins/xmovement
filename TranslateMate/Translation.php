<?php

namespace TranslateMate;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
	protected $fillable = [
	   'locale',
	   'group',
	   'key',
	   'value',
	];
}
