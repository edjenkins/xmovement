<?php

namespace XMovement\Scheduler;

use Illuminate\Database\Eloquent\Model;

use Auth;
use Response;

use App\User;

use Carbon\Carbon;

class SchedulerOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'xmovement_scheduler_id', 'value'
    ];

    protected $table = 'xmovement_scheduler_options';

    public function scheduler()
    {
        return $this->belongsTo(Scheduler::class, 'xmovement_scheduler_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function schedulerOptionVotes()
    {
        return $this->hasMany(SchedulerOptionVote::class, 'xmovement_scheduler_option_id');
    }

    public function voteCount()
    {
        return SchedulerOptionVote::where([['xmovement_scheduler_option_id', $this->id], ['latest', true]])->sum('value');
    }

    public function userVote()
    {
        // Check if user has voted on module
        $user_vote = SchedulerOptionVote::where([
            ['user_id', Auth::user()->id],
            ['xmovement_scheduler_option_id', $this->id],
            ['latest', true],
        ])->orderBy('created_at', -1)->first();

        return $user_vote['value'];
    }

    public function addVote($value)
    {
        // Check user can vote
        // Not locked

        if ($this->userVote() == $value)
        {
            // Prevent voting twice in one direction
            return false;
        }
        else
        {
            // Set old voted to inactive
            SchedulerOptionVote::where([
                'xmovement_scheduler_option_id' => $this->id,
                'user_id' => Auth::user()->id,
            ])->update(['latest' => false]);

            // Add new vote
            SchedulerOptionVote::create([
                'xmovement_scheduler_option_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value,
                'latest' => true
            ]);

            return true;
        }
    }

	public function getDay()
	{
		return Carbon::parse($this['value'])->format('jS');
	}

	public function getMonthYear()
	{
		return Carbon::parse($this['value'])->format('F Y');
	}

	public function getTime()
	{
		return Carbon::parse($this['value'])->format('g:i A');
	}

	public function getDate()
	{
		return Carbon::parse($this['value'])->format('D jS F y');
	}

	public function getTimeDate()
	{
		return Carbon::parse($this['value'])->format('D jS F y g:i A');
	}

    public function renderTile($schedulerOption)
    {
    	return view('scheduler::proposal-tile', ['schedulerOption' => $schedulerOption, 'proposal_mode' => false]);
    }
}
