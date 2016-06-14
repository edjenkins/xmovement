<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;
use XMovement\Scheduler\Scheduler;

use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can submit a scheduler option
     *
     * @param  User  $user
     * @param  Scheduler  $scheduler
     * @return bool
     */
    public function submitOption(User $user, Scheduler $scheduler)
    {
    	$designTask = DesignTask::where([['xmovement_task_id', $scheduler->id], ['xmovement_task_type', 'Scheduler']])->first();

        return (!$designTask["locked"] || ($user->id == $scheduler->user_id));
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
