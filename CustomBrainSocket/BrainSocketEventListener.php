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
use App\CommentTarget;

use Auth;
use Config;
use Crypt;
use DynamicConfig;
use Lang;
use Log;
use Validator;
use View;


class BrainSocketEventListener extends \BrainSocket\BrainSocketEventListener implements MessageComponentInterface {

	use DispatchesJobs;
    use \App\PostsComments;

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
			Log::info('BrainSocket : The user is not logged via an http session');
	    } else {
	        $currentUser = User::find($idUser);
			Log::info('BrainSocket : Current User - ' . $currentUser);
	    }

		$user_id = $currentUser->id;
		$text = json_decode($msg)->client->data->comment;
		$url = json_decode($msg)->client->data->url;
		$in_reply_to_comment_id = json_decode($msg)->client->data->in_reply_to_comment_id;

		$in_reply_to_comment_id = ($in_reply_to_comment_id == 0) ? NULL : $in_reply_to_comment_id;

		if (json_decode($msg)->client->event == 'comment.posted')
		{
			$res = json_decode($msg);

			// Post comment
			$comment = $this->postComment($text, $url, $in_reply_to_comment_id, $user_id);

			if ($comment)
			{
				$res->client->view = View::make('discussion.comment', ['comment' => $comment, 'authenticated_user' => $currentUser])->render();
			}
			else
			{
				$res->client->event = "comment.error";
				$res->client->user_id = $user_id;
				$res->client->errors = $validator->errors()->all();
			}

			foreach ($this->clients as $client)
			{
				$client->send($this->response->make(json_encode($res)));
			}
		}
	}
}
