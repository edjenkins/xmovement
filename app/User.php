<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\User;
use App\Idea;
use App\Proposal;
use App\Comment;
use App\DesignTask;
use App\DesignTaskVote;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shibboleth_id', 'facebook_id', 'linkedin_id', 'email', 'phone', 'name', 'bio', 'avatar', 'password', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token', 'phone', 'shibboleth_id', 'facebook_id', 'linkedin_id', 'email'
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
     * The actions performed in relation to a user.
     *
     * @var array
     */
    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    /**
     * The Design Tasks the user has created.
     *
     * @var array
     */
    public function design_tasks()
    {
        return $this->hasMany(DesignTask::class);
    }

    /**
     * The Votes a user has made on design tasks.
     *
     * @var array
     */
    public function design_task_votes()
    {
        return $this->hasMany(DesignTaskVote::class);
    }

    /**
     * The comments a user has posted.
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The Messages the user has received.
     *
     * @var array
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    /**
     * The Messages the user has received.
     *
     * @var array
     */
    public function recent_messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc')->take(10);
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
