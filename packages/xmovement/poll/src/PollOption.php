<?php

namespace XMovement\Poll;

use Illuminate\Database\Eloquent\Model;

use Auth;

use App\User;

class PollOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'xmovement_poll_id', 'value'
    ];

    protected $table = 'xmovement_poll_options';

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'xmovement_poll_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pollOptionVotes()
    {   
        return $this->hasMany(PollOptionVote::class, 'xmovement_poll_option_id');
    }

    public function voteCount()
    {
        return PollOptionVote::where([['xmovement_poll_option_id', $this->id], ['latest', true]])->sum('value');
    }

    public function userVote()
    {
        // Check if user has voted on module
        $user_vote = PollOptionVote::where([
            ['user_id', Auth::user()->id],
            ['xmovement_poll_option_id', $this->id],
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
            PollOptionVote::where([
                'xmovement_poll_option_id' => $this->id,
                'user_id' => Auth::user()->id,
            ])->update(['latest' => false]);

            // Add new vote
            PollOptionVote::create([
                'xmovement_poll_option_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value,
                'latest' => true
            ]);

            return true;
        }
    }
}