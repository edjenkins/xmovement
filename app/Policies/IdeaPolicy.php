<?php

namespace App\Policies;

use App\User;
use App\Idea;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can support the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function support(User $user, Idea $idea)
    {
        return true;
    }

    /**
     * Determine if the given user can design the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function design(User $user, Idea $idea)
    {
        return true;
    }

    /**
     * Determine if the given user can edit the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function edit(User $user, Idea $idea)
    {
        return $user->id === $idea->user_id;
    }

    /**
     * Determine if the given user can delete the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function destroy(User $user, Idea $idea)
    {
        return $user->id === $idea->user_id;
    }
}