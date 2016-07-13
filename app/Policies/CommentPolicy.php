<?php

namespace App\Policies;

use App\Comment;
use App\Idea;
use App\User;
use App\Supporter;
use App\DesignTask;
use Log;

use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given comment.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function destroy(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }

    /**
     * Determine if the given user can flag the given comment.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function flag(User $user, Comment $comment)
    {
        return $user->id != $comment->user_id;
    }
}
