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

	protected $appends = ['ideas_count'];

    public function ideas()
    {
        return $this->belongsToMany('App\Idea');
    }

    public function subcategories()
    {
        return $this->hasMany('App\IdeaCategory', 'parent_id', 'id');
    }

    public function getIdeasCountAttribute()
    {
		return $this->ideas()->count();
    }
}
