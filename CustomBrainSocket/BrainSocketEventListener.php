<?php
namespace CustomBrainSocket;

use Illuminate\Support\Facades\App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use Illuminate\Session\SessionManager;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Jobs\SendCommentReplyEmail;

use App\User;
use App\Comment;

use Auth;
use Config;
use Crypt;
use Lang;
use Log;
use Validator;
use View;


class BrainSocketEventListener extends \BrainSocket\BrainSocketEventListener implements MessageComponentInterface {

	use DispatchesJobs;

	public function onOpen(ConnectionInterface $conn) {

		$this->clients->attach($conn);
		// Create a new session handler for this client
		$session = (new SessionManager(App::getInstance()))->driver();
		// Get the cookies
		$cookies = $conn->WebSocket->request->getCookies();
		// Get the laravel's one
		$laravelCookie = urldecode($cookies[Config::get('session.cookie')]);
		// get the user session id from it
		$idSession = Crypt::decrypt($laravelCookie);
		// Set the session id to the session handler
		$session->setId($idSession);
		// Bind the session handler to the client connection
		$conn->session = $session;
	}

	public function onMessage(ConnectionInterface $from, $msg) {

	    $from->session->start();

		$idUser = $from->session->get(Auth::getName());

		Log::info('Auth::getName() - ' . Auth::getName());

		if (!isset($idUser)) {
	        echo "the user is not logged via an http session";
	    } else {
	        $currentUser = User::find($idUser);
	    }

		$user_id = $currentUser->id;
		$text = json_decode($msg)->client->data->comment;
		$url = json_decode($msg)->client->data->url;
		$in_reply_to_comment_id = (json_decode($msg)->client->data->in_reply_to_comment_id == "") ? NULL : json_decode($msg)->client->data->in_reply_to_comment_id;

		$url = preg_replace("(^https?://)", "", $url);

		if (json_decode($msg)->client->event == 'comment.posted')
		{
			$data = [
				'text' => $text,
				'url' => $url,
			];

			// Validate comment
			$validator = Validator::make($data, [
				'text' => 'required|between:2,500',
				'url' => 'required',
			]);

			$res = json_decode($msg);

	        if ($validator->fails())
			{
				$res->client->event = "comment.error";
				$res->client->user_id = $user_id;
				$res->client->errors = $validator->errors()->all();
			}
			else
			{
				$comment = Comment::create([
					'user_id' => $user_id,
					'text' => $text,
					'url' => $url,
					'in_reply_to_comment_id' => $in_reply_to_comment_id
				]);

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

				$res->client->view = View::make('discussion.comment', ['comment' => $comment, 'authenticated_user' => $currentUser])->render();
			}

			$msg = json_encode($res);

			foreach ($this->clients as $client)
			{
				$client->send($this->response->make($msg));
			}
		}
	}
}
