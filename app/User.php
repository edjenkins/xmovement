<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\User;
use App\Idea;
use App\Proposal;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id', 'email', 'phone', 'name', 'bio', 'avatar', 'password', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The Ideas the user has created.
     *
     * @var array
     */
    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    /**
     * The Proposals the user has created.
     *
     * @var array
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * The Ideas the user has supported.
     *
     * @var array
     */
    public function supportedIdeas()
    {
        return $this->belongsToMany(Idea::class, 'supporters')->withTimestamps();
    }

    /**
     * Check if the user has supported the given idea.
     *
     * @var array
     */
    public function hasSupportedIdea(Idea $idea)
    {
        return Supporter::where('user_id', $this->id)->where('idea_id', $idea->id)->exists();
    }

    /**
     * Check if the user is a super admin
     *
     * @var array
     */
    public function isSuperAdmin()
    {
        return $this->super_admin;
    }
}
