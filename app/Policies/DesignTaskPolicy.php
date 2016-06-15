<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;

use Illuminate\Auth\Access\HandlesAuthorization;

class DesignTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given design task.
     *
     * @param  User  $user
     * @param  DesignTask  $design_task
     * @return bool
     */
    public function destroy(User $user, DesignTask $design_task)
    {
        return $user->id == $design_task->user_id;
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
