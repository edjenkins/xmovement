<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MartinBean\Database\Eloquent\Sluggable;

use Auth;
use Carbon\Carbon;
use DynamicConfig;
use Log;

use App\DesignTask;
use App\Report;

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

  	protected $appends = ['supporter_count', 'latest_phase', 'supported', 'category'];
    protected $dates = ['deleted_at'];

  	use Sluggable;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany('App\IdeaCategory');
    }

    /**
     * The actions performed in relation to an idea.
     *
     * @var array
     */
    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    /**
     * The updates posted for this idea.
     *
     * @var array
     */
  	public function updates()
  	{
  		return $this->morphMany('App\Update', 'updateable');
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
     * The Votes cast on design tasks for the idea.
     *
     * @var array
     */
    public function designTaskVotes()
    {
        return $this->hasMany(DesignTaskVote::class);
    }

    /**
     * The featured Design Tasks for the idea.
     *
     * @var array
     */
    public function featuredDesignTasks()
    {
        return $this->designTasks()->take(3);
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

    /**
     * The Tenders for the idea.
     *
     * @var array
     */
    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    /**
     * The winning Proposal for the idea.
     *
     * @var array
     */
    public function winning_proposal()
    {
		$proposals = collect($this->proposals)->sortByDesc(function ($proposal, $key) {
            return sprintf('%s', $proposal->voteCount());
        })->values()->all();

		if ($proposals)
		{
			return $proposals[0];
		}
		else
		{
			return null;
		}
    }

    public function getCategoryAttribute()
    {
		return $this->categories()->orderBy('idea_categories.parent_id', 'desc')->first();
    }

    public function supporterCount()
    {
        return Supporter::where('idea_id', $this->id)->count();
    }

    /**
     * Check if user has supported this idea
     *
     * @return bool
     */
    public function getSupportedAttribute()
    {
		if (Auth::user())
		{
			return Supporter::where('user_id', Auth::user()->id)->where('idea_id', $this->id)->exists();
		}
		else
		{
			return false;
		}
    }

    /**
     * Get the supporters count
     *
     * @return int
     */
    public function getSupporterCountAttribute()
    {
        return $this->supporterCount();
    }

    /**
     * Get the latest state
     *
     * @return string
     */
    public function getLatestPhaseAttribute()
    {
  		if ($this->plan_state() == 'open')
  		{
  			return 'Plan Phase';
  		}
  		else if ($this->design_state() == 'open')
  		{
  			return 'Design Phase';
  		}
  		else if ($this->support_state() == 'open')
  		{
  			return 'Support Phase';
  		}

      return 'Complete';
    }

	public function attachCategories($category_id)
	{
		if ($category_id)
		{
			$this->categories()->detach();

			$idea_category = IdeaCategory::where('id', $category_id)->first();

			if ($idea_category)
			{
				$this->categories()->attach($idea_category);

				Log::error('$idea_category->id');
				Log::error($idea_category->id);

				while ($idea_category->parent_id)
				{
					$idea_category = IdeaCategory::where('id', $idea_category->parent_id)->first();
					$this->categories()->attach($idea_category->id);
				}
			}
		}
	}

	/**
	 * Add a design task to an idea (pre-populate)
	 */
	public function addDesignTask($name, $description, $xmovement_task_type)
	{
		switch ($xmovement_task_type) {
			case 'Poll':
				if (!DynamicConfig::fetchConfig('XMOVEMENT_POLL')) { return; }
				$xmovement_task_id = \XMovement\Poll\Poll::create([
					'user_id' => $this->user_id,
					'contribution_type' => 'text',
					'voting_type' => 'standard'
				])->id;
				break;

			case 'Discussion':
				if (!DynamicConfig::fetchConfig('XMOVEMENT_DISCUSSION')) { return; }
				$xmovement_task_id = \XMovement\Discussion\Discussion::create([
					'user_id' => $this->user_id,
				])->id;
				break;
		}

		$design_task = DesignTask::create([
			'idea_id' => $this->id,
			'user_id' => $this->user_id,
			'name' => $name,
			'description' => $description,
			'xmovement_task_id' => $xmovement_task_id,
			'xmovement_task_type' => $xmovement_task_type,
			'proposal_interactivity' => false,
			'pinned' => true,
			'locked' => false,
			'pre_populated' => true,
		]);
	}

    /**
     * The supporters of the Idea.
     */
    public function supporters()
    {
        return $this->belongsToMany(User::class, 'supporters')->withTimestamps();
    }

    /**
     * The comments for the Idea.
     */
    public function getComments()
    {
		$url = action('IdeaController@view', $this->id);

		$url_with_slug = $url . '/' . $this->slug;

        return Comment::where('url', $url)->orWhere('url', $url_with_slug)->get();
    }

    /**
     * The share butotn clicks for the Idea.
     */
    public function getShareButtonClicks()
    {
		$share_button_clicks = [];

		$labels = ['facebook-share-button-click', 'facebook-share-button-click', 'twitter-share-button-click', 'googleplus-share-button-click', 'email-share-button-click'];

		foreach ($this->actions as $key => $action)
		{
			if (in_array($action['label'], $labels))
			{
				array_push($share_button_clicks, $action);
			}
		}

        return $share_button_clicks;
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

  	public function proposalPhaseCloses()
  	{
  		return Carbon::parse($this->timescales('proposal', 'end'))->diffForHumans(null, true);
  	}

  	public function timescales($phase, $point)
  	{
  		$progression_type = DynamicConfig::fetchConfig('PROGRESSION_TYPE', 'fixed');

  		$process_start_date = ($progression_type == 'fixed') ? strtotime(DynamicConfig::fetchConfig('PROCESS_START_DATE')) : strtotime($this->created_at);

  		$inspiration_phase = json_decode(DynamicConfig::fetchConfig('INSPIRATION_PHASE'));
  		$inspiration_start = Carbon::createFromTimestamp(strtotime("+" . $inspiration_phase->start . " days", $process_start_date));
  		$inspiration_end = Carbon::createFromTimestamp(strtotime("+" . $inspiration_phase->end . " days", $process_start_date));

  		$support_phase = json_decode(DynamicConfig::fetchConfig('SUPPORT_PHASE'));
  		$support_start = Carbon::createFromTimestamp(strtotime("+" . $support_phase->start . " days", $process_start_date));
  		$support_end = Carbon::createFromTimestamp(strtotime("+" . $support_phase->end . " days", $process_start_date));

  		$design_phase = json_decode(DynamicConfig::fetchConfig('DESIGN_PHASE'));
  		$design_start = Carbon::createFromTimestamp(strtotime("+" . $design_phase->start . " days", $process_start_date));
  		$design_end = Carbon::createFromTimestamp(strtotime("+" . $design_phase->end . " days", $process_start_date));

  		$proposal_phase = json_decode(DynamicConfig::fetchConfig('PLAN_PHASE'));
  		$proposal_start = Carbon::createFromTimestamp(strtotime("+" . $proposal_phase->start . " days", $process_start_date));
  		$proposal_end = Carbon::createFromTimestamp(strtotime("+" . $proposal_phase->end . " days", $process_start_date));

  		$tender_phase = json_decode(DynamicConfig::fetchConfig('TENDER_PHASE'));
  		$tender_start = Carbon::createFromTimestamp(strtotime("+" . $tender_phase->start . " days", $process_start_date));
  		$tender_end = Carbon::createFromTimestamp(strtotime("+" . $tender_phase->end . " days", $process_start_date));

  		switch ($phase) {
  			case 'inspiration':

  				switch ($point) {
  					case 'start': return $inspiration_start; break;
  					case 'duration': return $inspiration_duration; break;
  					case 'end': return $inspiration_end; break;
  				}
  				break;

  			case 'support':

  				switch ($point) {
  					case 'start': return $support_start; break;
  					case 'duration': return $support_duration; break;
  					case 'end': return $support_end; break;
  				}
  				break;

  			case 'design':

  				switch ($point) {
  					case 'start': return $design_start; break;
  					case 'duration': return $design_duration; break;
  					case 'end': return $design_end; break;
  				}
  				break;

  			case 'proposal':

  				switch ($point) {
  					case 'start': return $proposal_start; break;
  					case 'duration': return $proposal_duration; break;
  					case 'end': return $proposal_end; break;
  				}
  				break;

  			case 'tender':

  				switch ($point) {
  					case 'start': return $tender_start; break;
  					case 'duration': return $tender_duration; break;
  					case 'end': return $tender_end; break;
  				}
  				break;
  		}
  	}

    function support_state()
    {
      $support_start = $this->timescales('support', 'start');
      $support_end = $this->timescales('support', 'end');

      if (!Carbon::now()->between($support_start, $support_end))
			{
        if (Carbon::now()->gt($support_end))
        {
          if ((DynamicConfig::fetchConfig('MIN_SUPPORTER_COUNT', 0) - $this->supporterCount()) > 0)
          {
            // Not enough supporters
            return 'failed';
          }
          else
          {
            // Enough supporters!
            return 'locked';
          }
        }
			}
      return 'open';
    }

    function design_state()
    {
      $design_start = $this->timescales('design', 'start');
      $design_end = $this->timescales('design', 'end');

      $state = '';

      if (!Carbon::now()->between($design_start, $design_end))
			{
				$state = (Carbon::now()->gt($design_end)) ? 'locked' : 'closed';
			}
      else
      {
        $state = 'open';
      }

      // Check support phase was successful
      return ($this->support_state() == 'failed') ? 'closed' : $state;
    }

    function proposal_state()
    {
      $proposal_start = $this->timescales('proposal', 'start');
      $proposal_end = $this->timescales('proposal', 'end');

      $state = '';

      if (!Carbon::now()->between($proposal_start, $proposal_end))
			{
				$state = (Carbon::now()->gt($proposal_end)) ? 'locked' : 'closed';
			}
      else
      {
        $state = 'open';
      }

      // Check support phase was successful
      return ($this->support_state() == 'failed') ? 'closed' : $state;
    }

    function tender_state()
    {
      $tender_start = $this->timescales('tender', 'start');
      $tender_end = $this->timescales('tender', 'end');

      $state = '';

      if (!Carbon::now()->between($tender_start, $tender_end))
			{
				$state = (Carbon::now()->gt($tender_end)) ? 'locked' : 'closed';
			}
      else
      {
        $state = 'open';
      }

      // Check support phase was successful
      return ($this->support_state() == 'failed') ? 'closed' : $state;
    }

    function plan_state()
    {
      $design_start = $this->timescales('design', 'start');
      $design_end = $this->timescales('design', 'end');

      $state = '';

      if (!Carbon::now()->gt($design_end))
      {
        $state = 'closed';
      }
      else
      {
        $state = 'open';
      }

      // Check support phase was successful
      return ($this->support_state() == 'failed') ? 'closed' : $state;
    }
}
