<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
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

}