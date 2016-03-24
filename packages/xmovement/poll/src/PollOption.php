<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

use Auth;

class PollOption extends Model
{
    protected $table = 'xmovement_poll_options';

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'xmovement_poll_id');
    }

    public function pollOptionVotes()
    {   
        return $this->hasMany(PollOptionVote::class, 'xmovement_poll_option_id');
    }

    public function voteCount()
    {
        return PollOptionVote::where('xmovement_poll_option_id', $this->id)->sum('value');
    }

    public function userVote()
    {
        // Check if user has voted on module
        $user_vote = PollOptionVote::where([
            ['user_id', Auth::user()->id],
            ['xmovement_poll_option_id', $this->id],
        ])->orderBy('created_at')->first();

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
            PollOptionVote::insert([
                'xmovement_poll_option_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value
            ]);

            return true;
        }
    }
}