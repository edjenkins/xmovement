<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Poll extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contribution_type', 'voting_type'
    ];

    protected $table = 'xmovement_polls';

    public function renderTile($design_task)
    {
    	return view('poll::tile', ['poll' => $this, 'design_task' => $design_task]);
    }

    public function pollOptions()
    {
        return $this->hasMany(PollOption::class, 'xmovement_poll_id');
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

    public function addOption($value)
    {
        // Check user can vote
        // Not locked

        if (false)
        {
            // Prevent voting twice in one direction
            return false;
        }
        else
        {
            $pollOption = PollOption::create([
                'xmovement_poll_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value
            ]);

            return $pollOption;
        }
    }

}