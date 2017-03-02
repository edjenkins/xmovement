<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'enabled',
		'parent_id'
    ];

    public function ideas()
    {
        return $this->belongsToMany('App\Idea');
    }
}
