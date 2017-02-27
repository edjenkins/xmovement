<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentTarget extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target_id', 'target_type', 'idea_id', 'url', 'locked'
    ];

    public function comments()
	{
        return $this->hasMany('App\Comment', 'comment_target_id');
    }
}
