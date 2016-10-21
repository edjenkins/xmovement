<?php

namespace App\Policies;

use App\Team;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create a new team.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return bool
     */
    public function create(User $user)
    {
		// TODO: Check if user can create a team?
        return false;
    }

    /**
     * Determine if the given user can add a new team member.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return bool
     */
    public function add_user(User $user, Team $team)
    {
		// TODO: Check if user is a member of the team not just the creator
        return $user->id == $team->user_id;
    }

    /**
     * Determine if the given user can remove a team member.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return bool
     */
    public function remove_user(User $user, Team $team)
    {
		// TODO: Check if user is a member of the team not just the creator
        return $user->id == $team->user_id;
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
