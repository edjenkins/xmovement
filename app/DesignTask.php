<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\DesignTaskVote;

use Auth;

class DesignTask extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idea_id', 'user_id', 'name', 'description', 'xmovement_task_id', 'xmovement_task_type', 'locked'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function xmovement_task()
    {
        return $this->morphTo();
    }

    public function voteCount()
    {
        return DesignTaskVote::where([['design_task_id', $this->id], ['latest', true]])->sum('value');
    }

    public function userVote()
    {
        // Check if user has voted on module
        $user_vote = DesignTaskVote::where([
            ['user_id', Auth::user()->id],
            ['design_task_id', $this->id],
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
            DesignTaskVote::where([
                'design_task_id' => $this->id,
                'user_id' => Auth::user()->id,
            ])->update(['latest' => false]);

            // Add new vote
            DesignTaskVote::create([
                'design_task_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value,
                'latest' => true
            ]);

            return true;
        }
    }
}
