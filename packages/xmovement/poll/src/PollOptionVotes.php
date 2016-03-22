<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

class PollOptionVotes extends Model
{
    protected $table = 'xmovement_poll_option_votes';

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'xmovement_poll_id');
    }
}