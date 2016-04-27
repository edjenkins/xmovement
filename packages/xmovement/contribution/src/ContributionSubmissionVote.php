<?php

namespace XMovement\Contribution;

use Illuminate\Database\Eloquent\Model;

class ContributionSubmissionVote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xmovement_contribution_submission_id', 'user_id', 'value'
    ];
    
    protected $table = 'xmovement_contribution_submission_votes';

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'xmovement_contribution_id');
    }
}