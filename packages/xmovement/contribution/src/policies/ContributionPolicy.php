<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;
use XMovement\Contribution\Contribution;

use Illuminate\Auth\Access\HandlesAuthorization;

class ContributionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can submit a contribution submission
     *
     * @param  User  $user
     * @param  Contribution  $contribution
     * @return bool
     */
    public function submitSubmission(User $user, Contribution $contribution)
    {
    	$designTask = DesignTask::where([['xmovement_task_id', $contribution->id], ['xmovement_task_type', 'Contribution']])->first();
		
        return (!$designTask["locked"] || ($user->id == $contribution->user_id));
    }

    /**
     * Override all policy restrictions if the user is a super admin
     *
     * @param  User  $user
     * @param  $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }
}