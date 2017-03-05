<?php

namespace App;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Jobs\SendCommentReplyEmail;

use App\User;
use App\Comment;
use App\CommentTarget;

use Auth;
use Config;
use Crypt;
use DynamicConfig;
use Lang;
use Log;
use Validator;
use View;

trait PostsComments
{
    protected function postComment($text, $url, $in_reply_to_comment_id, $user_id)
    {
		if (!$user_id)
		{
			$user_id = Auth::user()->id;
		}

		$currentUser = User::where('id', $user_id)->first();

		$url = preg_replace("(^https?://)", "", $url);

		$comment_target = CommentTarget::where('url', $url)->first();

		// Validate comment
		$validator = Validator::make(['text' => $text, 'url' => $url], [
			'text' => 'required|between:2,500',
			'url' => 'required',
		]);

		if ($validator->fails() || $comment_target->locked)
		{
			Log::error('Validator failed or comment target was locked');

			return false;
		}
		else
		{
			$comment = Comment::create([
				'user_id' => $user_id,
				'text' => $text,
				'comment_target_id' => $comment_target->id,
				'url' => $url,
				'in_reply_to_comment_id' => $in_reply_to_comment_id
			]);

			$comment = Comment::where('id', $comment->id)->with('commentTarget')->first();

			if ($in_reply_to_comment_id)
			{
				// Send email notification to original commenter
				$in_reply_to_comment = Comment::where('id', $in_reply_to_comment_id)->with('user')->first();
				$reply = $comment;

				if ($in_reply_to_comment->user->id != $user_id)
				{
					// Notify users via email
					$job = (new SendCommentReplyEmail($currentUser, $in_reply_to_comment->user, $in_reply_to_comment, $reply))->delay(5)->onQueue('emails');
					$this->dispatch($job);
				}
			}

			// $comment->comment_target = $comment_target;

	        return $comment;
		}
    }
}
