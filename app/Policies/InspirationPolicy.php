<?php

namespace App\Policies;

use App\User;
use App\Inspiration;
use Log;

use Illuminate\Auth\Access\HandlesAuthorization;

class InspirationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create a new inspiration.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

	/**
	 * Determine if the given user can delete the given inspiration.
	 *
	 * @param  User  $user
	 * @param  Inspiration  $inspiration
	 * @return bool
	 */
	public function destroy(User $user, Inspiration $inspiration)
	{
		return $user->id == $inspiration->user_id;
	}

	/**
	 * Determine if the given user can favourite the given inspiration.
	 *
	 * @param  User  $user
	 * @param  Inspiration  $inspiration
	 * @return bool
	 */
	public function favourite(User $user, Inspiration $inspiration)
	{
		return true;
	}
}
