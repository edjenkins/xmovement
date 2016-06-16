<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

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
        return Supporter::where('idea_id', $this->id)->count();
    }

    /**
     * The supporters of the Idea.
     */
    public function supporters()
    {
        return $this->belongsToMany(User::class, 'supporters')->withTimestamps();
    }

    /**
     * The supporters of the Idea.
     */
    public function get_supporters()
    {
        return Supporter::where('idea_id', $this->id)->get();
    }

	public function designPhaseOpens()
	{
		return Carbon::parse($this->timescales('design', 'start'))->diffForHumans(null, true);
	}

	public function proposalPhaseOpens()
	{
		return Carbon::parse($this->timescales('proposal', 'start'))->diffForHumans(null, true);
	}

	public function timescales($phase, $point)
	{
		$now = Carbon::now();

		$created = Carbon::parse($this->created_at);

		$support_start = $design_start = $proposal_start = $created->copy();

		$support_end = $design_end = $proposal_end = Carbon::now();

		$idea_duration_in_hours = ($this->duration * 24);

		if (($this->design_during_support) && ($this->proposals_during_design))
		{
			$support_duration = $design_duration = $proposal_duration = $idea_duration_in_hours;

			$support_end = $design_end = $proposal_end = $created->copy()->addHours($idea_duration_in_hours);
		}
		else if ($this->design_during_support)
		{
			$support_duration = $design_duration = $proposal_duration = ($idea_duration_in_hours / 2);

			$proposal_start = $created->copy()->addHours($support_duration);

			$support_end = $support_start->copy()->addHours($support_duration);
			$design_end = $design_start->copy()->addHours($design_duration);
			$proposal_end = $design_end->copy()->addHours($proposal_duration);
		}
		else if ($this->proposals_during_design)
		{
			$support_duration = $design_duration = $proposal_duration = ($idea_duration_in_hours / 2);

			$design_start = $proposal_start = $created->copy()->addHours($support_duration);

			$support_end = $support_start->copy()->addHours($support_duration);
			$design_end = $support_end->copy()->addHours($design_duration);
			$proposal_end = $support_end->copy()->addHours($proposal_duration);
		}
		else
		{
			$support_duration = $design_duration = $proposal_duration = ($idea_duration_in_hours / 3);

			$design_start = $support_start->copy()->addHours($support_duration);
			$proposal_start = $design_start->copy()->addHours($design_duration);

			$support_end = $created->copy()->addHours($support_duration);
			$design_end = $support_end->copy()->addHours($design_duration);
			$proposal_end = $design_end->copy()->addHours($proposal_duration);
		}

		switch ($phase) {
			case 'support':

				switch ($point) {
					case 'start':
						return $support_start;
						break;

					case 'duration':
						return $support_duration;
						break;

					case 'end':
						return $support_end;
						break;
				}
				break;

			case 'design':

				switch ($point) {
					case 'start':
						return $design_start;
						break;

					case 'duration':
						return $design_duration;
						break;

					case 'end':
						return $design_end;
						break;
				}
				break;

			case 'proposal':

				switch ($point) {
					case 'start':
						return $proposal_start;
						break;

					case 'duration':
						return $proposal_duration;
						break;

					case 'end':
						return $proposal_end;
						break;
				}
				break;
		}
	}

}
