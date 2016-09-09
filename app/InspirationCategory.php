<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspirationCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'enabled'
    ];

    public function inspirations()
    {
        return $this->belongsToMany('App\Inspiration');
    }
}
