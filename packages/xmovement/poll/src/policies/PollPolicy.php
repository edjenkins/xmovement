<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;
use XMovement\Poll\Poll;

use Illuminate\Auth\Access\HandlesAuthorization;

class PollPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can submit a poll option
     *
     * @param  User  $user
     * @param  Poll  $poll
     * @return bool
     */
    public function submitOption(User $user, Poll $poll)
    {
    	$designTask = DesignTask::where([['xmovement_task_id', $poll->id], ['xmovement_task_type', 'Poll']])->first();
		
        return (!$designTask["locked"] || ($user->id === $poll->user_id));
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