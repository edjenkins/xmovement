<?php

namespace App\Policies;

use App\Proposal;
use App\User;
use App\Supporter;
use App\DesignTask;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProposalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can edit the given proposal.
     *
     * @param  User  $user
     * @param  Proposal  $proposal
     * @return bool
     */
    public function edit(User $user, Proposal $proposal)
    {
        return $user->id === $proposal->user_id;
    }

    /**
     * Determine if the given user can delete the given proposal.
     *
     * @param  User  $user
     * @param  Proposal  $proposal
     * @return bool
     */
    public function destroy(User $user, Proposal $proposal)
    {
        return $user->id === $proposal->user_id;
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
