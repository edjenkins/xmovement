<?php

namespace XMovement\Contribution;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Contribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contribution_type', 'voting_type'
    ];

    protected $table = 'xmovement_contributions';

    public function renderTile($design_task)
    {
    	return view('contribution::tile', ['contribution' => $this, 'design_task' => $design_task]);
    }

    public function contributionOptions()
    {
        return $this->hasMany(ContributionOption::class, 'xmovement_contribution_id');
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

    public function addOption($value)
    {
        // Check user can vote
        // Not locked

        if (false)
        {
            // Prevent voting twice in one direction
            return false;
        }
        else
        {
            $contributionOption = ContributionOption::create([
                'xmovement_contribution_id' => $this->id,
                'user_id' => Auth::user()->id,
                'value' => $value
            ]);

            return $contributionOption;
        }
    }

}