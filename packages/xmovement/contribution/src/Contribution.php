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

    public function renderSubmitForm()
    {
        return view('contribution::forms::add', ['contribution' => $this]);
    }

    public function contributionTypes()
    {
        return $this->hasManyThrough(ContributionAvailableType::class, ContributionType::class, 'xmovement_contribution_id', 'id');
    }

    public function contributionSubmissions()
    {
        return $this->hasMany(ContributionSubmission::class, 'xmovement_contribution_id');
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

    public function addSubmission($submission_type, $value)
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
            $contributionSubmission = ContributionSubmission::create([
                'xmovement_contribution_id' => $this->id,
                'user_id' => Auth::user()->id,
                'xmovement_contribution_available_type_id' => $submission_type,
                'value' => $value
            ]);

            return $contributionSubmission;
        }
    }

}