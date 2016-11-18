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
        return (($user->id == $design_task->user_id) && ($design_task->idea->design_state == 'open'));
    }

    /**
     * Determine if the given user can delete the given design task.
     *
     * @param  User  $user
     * @param  DesignTask  $design_task
     * @return bool
     */
    public function flag(User $user, DesignTask $design_task)
    {
		return false; // TODO: Add flag functionality
		$is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $design_task->idea->id)->exists();
        return $is_existing_supporter;
    }

    /**
     * Determine if the given user can submit a contribution
     *
     * @param  User  $user
     * @param  Poll  $design_task
     * @return bool
     */
    public function contribute(User $user, DesignTask $design_task)
    {
    	$is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $design_task->idea->id)->exists();
        return ((!$design_task["locked"] || ($user->id == $design_task->user_id)) && $is_existing_supporter && ($design_task->idea->design_state == 'open'));
    }

    /**
     * Determine if the given user can vote on design tasks for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function vote_on_design_submissions(User $user, DesignTask $design_task)
    {
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $design_task->idea->id)->exists();
		return ($is_existing_supporter && ($design_task->idea->design_state == 'open'));
    }

    /**
     * Determine if the given user can vote on design tasks for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function vote_on_design_tasks(User $user, DesignTask $design_task)
    {
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $design_task->idea->id)->exists();
		return ($is_existing_supporter && ($design_task->idea->design_state == 'open'));
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
