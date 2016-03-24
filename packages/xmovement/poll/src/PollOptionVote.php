<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

class PollOptionVote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xmovement_poll_option_id', 'user_id', 'value'
    ];
    
    protected $table = 'xmovement_poll_option_votes';

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'xmovement_poll_id');
    }
}