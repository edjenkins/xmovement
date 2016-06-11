<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'description',
		'photo',
		'visibility',
		'support_state',
		'design_state',
		'proposal_state',
		'supporters_target',
		'duration',
		'design_during_support',
		'proposals_during_design',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Design Tasks for the idea.
     *
     * @var array
     */
    public function designTasks()
    {
        return $this->hasMany(DesignTask::class);
    }

    /**
     * The Proposals for the idea.
     *
     * @var array
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function supporterCount()
    {
        return Supporter::where('idea_id',
		$this->id)->count();
    }

    /**
     * The supporters of the Idea.
     */
    public function supporters()
    {
        return $this->belongsToMany(User::class, 'supporters')->withTimestamps();
    }
}
