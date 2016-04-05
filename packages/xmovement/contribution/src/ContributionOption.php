<?php

namespace XMovement\Contribution;

use Illuminate\Database\Eloquent\Model;

use Auth;

use App\User;

class ContributionOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'xmovement_contribution_id', 'value'
    ];

    protected $table = 'xmovement_contribution_options';

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'xmovement_contribution_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contributionOptionVotes()
    {   
        return $this->hasMany(ContributionOptionVote::class, 'xmovement_contribution_option_id');
    }

    public function voteCount()
    {
        return ContributionOptionVote::where([['xmovement_contribution_option_id', $this->id], ['latest', true]])->sum('value');
    }

    public function userVote()
    {
        // Check if user has voted on module
        $user_vote = ContributionOptionVote::where([
            ['user_id', Auth::user()->id],
            ['xmovement_contribution_option_id', $this->id],
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
            ContributionOptionVote::where([
                'xmovement_contribution_option_id' => $this->id,
                'user_id' => Auth::user()->id,
            ])->update(['latest' => false]);

            // Add new vote
            ContributionOptionVote::create([
                'xmovement_contribution_option_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value,
                'latest' => true
            ]);

            return true;
        }
    }
}