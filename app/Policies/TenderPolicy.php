<?php

namespace App\Policies;

use App\Tender;
use App\User;
use App\Supporter;

use Illuminate\Auth\Access\HandlesAuthorization;

class TenderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can edit the given tender.
     *
     * @param  User  $user
     * @param  Tender  $tender
     * @return bool
     */
    public function edit(User $user, Tender $tender)
    {
        return $user->id == $tender->user_id;
    }

    /**
     * Determine if the given user can post an update.
     *
     * @param  User  $user
     * @param  Tender  $tender
     * @return bool
     */
    public function post_update(User $user, Tender $tender)
    {
		// TODO: Check if user can post an update to tender?
        return $user->id == $tender->user_id;
    }

    /**
     * Determine if the given user can delete the given tender.
     *
     * @param  User  $user
     * @param  Tender  $tender
     * @return bool
     */
    public function destroy(User $user, Tender $tender)
    {
        return $user->id == $tender->user_id;
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
