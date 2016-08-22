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
}
