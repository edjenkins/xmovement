<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can view the news stream of the user.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function viewNews(User $user, User $profile)
    {
        return true;
    }

    /**
     * Determine if the given user can view the messages of the user.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function viewMessages(User $user, User $profile)
    {
        return $user->id === $profile->id;
    }

    /**
     * Determine if the given user can edit the preferences of the user.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function editPreferences(User $user, User $profile)
    {
        return $user->id === $profile->id;
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