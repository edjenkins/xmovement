<?php

namespace App\Policies;

use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;
use DynamicConfig;
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
     * Determine if the given user can access the toolkit.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function accessToolkit(User $user, Idea $idea)
    {
        return false;
        return ((($user->id == $idea->user_id) || $user->admin) && ($idea->plan_state() == 'open'));
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
        return (($user->id == $idea->user_id) || $user->admin);
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
        return (($user->id == $idea->user_id) || $user->admin);
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
     * Determine if the given user can design the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function design(User $user, Idea $idea)
    {
        return ($idea->design_state != 'closed');
    }

    /**
     * Determine if the given user can submit a contribution to given idea
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function contribute(User $user, Idea $idea)
    {
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
        return ($idea->design_state == "open" && ($is_existing_supporter || DynamicConfig::fetchConfig('UNRESTRICTED_DESIGN', false)));
    }

    /**
     * Determine if the given user can open the design phase early
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function open_design_phase(User $user, Idea $idea)
    {
        return false; // TODO: Prevent opening of design phase early
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
        return ($idea->design_state == "closed" && $is_existing_supporter && ($user->id == $idea->user_id));
    }

    /**
     * Determine if the given user can pin a design task in the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function pinDesignTask(User $user, Idea $idea)
    {
        return (($user->id == $idea->user_id) || $user->admin);
    }

    /**
     * Determine if the given user can post an update for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function postUpdate(User $user, Idea $idea)
    {
        return ((($user->id == $idea->user_id) && (DynamicConfig::fetchConfig('IDEA_UPDATES_ENABLED', false))) || $user->admin) ;
    }

    /**
     * Determine if the given user can destroy an update for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function destroyUpdate(User $user, Idea $idea)
    {
        return (($user->id == $idea->user_id) || $user->admin);
    }


    /**
     * Determine if the given user can lock a design task in the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function lockDesignTask(User $user, Idea $idea)
    {
        return (($user->id == $idea->user_id) || $user->admin);
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
        return (($idea->design_state == 'open') || DynamicConfig::fetchConfig('UNRESTRICTED_DESIGN', false));
    }

    /**
     * Determine if the given user can view proposals for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function view_proposals(User $user, Idea $idea)
    {
        return ($idea->proposal_state != 'closed');
    }

    /**
     * Determine if the given user can submit a proposal for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function add_proposal(User $user, Idea $idea)
    {
        $is_existing_supporter = Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists();
        return (($is_existing_supporter || $user->admin || DynamicConfig::fetchConfig('UNRESTRICTED_DESIGN', false)) && ($idea->proposal_state == 'open'));
    }

    /**
     * Determine if the given user can view proposals for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function view_tenders(User $user, Idea $idea)
    {
        return ($idea->tender_state != 'closed');
    }

    /**
     * Determine if the given user can submit a tender for the given idea.
     *
     * @param  User  $user
     * @param  Idea  $idea
     * @return bool
     */
    public function submit_tender(User $user, Idea $idea)
    {
        return ($idea->tender_state == 'open');
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
          if ($ability === 'accessToolkit' || $ability === 'support' || $ability === 'postUpdate') {

          } else {
            return true;
          }
        }
    }
}
