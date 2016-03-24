<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\DesignModuleVote;

use Auth;

class DesignModule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idea_id', 'user_id', 'xmovement_module_id', 'xmovement_module_type', 'locked'
    ];
    
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function xmovement_module()
    {
        return $this->morphTo();
    }

    public function voteCount()
    {
        return DesignModuleVote::where('design_module_id', $this->id)->sum('value');
    }

    public function userVote()
    {
        // Check if user has voted on module
        $user_vote = DesignModuleVote::where([
            ['user_id', Auth::user()->id],
            ['design_module_id', $this->id],
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
            DesignModuleVote::insert([
                'design_module_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value
            ]);

            return true;
        }
    }
}
