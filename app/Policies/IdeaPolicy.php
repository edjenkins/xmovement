<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;
use Log;

use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can invite users to the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function invite(User $user, Idea $idea)
    {
        return $user->id == $idea->user_id;
    }

    /**
     * Determine if the given user can support the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function support(User $user, Idea $idea)
    {
		$is_not_existing_supporter = !Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
        return ($is_not_existing_supporter && ($idea->support_state == 'open'));
    }

    /**
     * Determine if the given user has supported the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function supported(User $user, Idea $idea)
    {
        return Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
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
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
		return ($is_existing_supporter && ($idea->design_state == 'open'));
    }

    /**
     * Determine if the given user can design the given idea after they have supported it.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function design_after_support(User $user, Idea $idea)
    {
		return ($idea->design_state == 'open');
    }

    /**
     * Determine if the given user can submit a proposal for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function propose(User $user, Idea $idea)
    {
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
		return ($is_existing_supporter && ($idea->proposal_state == 'open'));
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
        return $user->id == $idea->user_id;
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
        return $user->id == $idea->user_id;
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
