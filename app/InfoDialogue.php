<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoDialogue extends Model
{
	protected $fillable = [
	   'key',
	   'title',
	   'content',
	];
}
