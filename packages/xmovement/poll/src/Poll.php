<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'xmovement_polls';

    public function renderTile($module)
    {
    	return view('poll::tile', ['poll' => $this, 'module' => $module]);
    }

    public function pollOptions()
    {
        return $this->hasMany(PollOptions::class, 'xmovement_poll_id');
    }

    public function designModule()
    {
        return $this->morphMany('App\DesignModule', 'xmovement_module');
    }

}