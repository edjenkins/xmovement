<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

class PollOptions extends Model
{
    protected $table = 'xmovement_poll_options';

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'xmovement_poll_id');
    }

    public function pollOptionVotes()
    {   
        return $this->hasMany(PollOptionVotes::class, 'xmovement_poll_option_id');
    }

    public function voteCount()
    {
        return PollOptionVotes::where('xmovement_poll_option_id', $this->id)->sum('value');
    }
}