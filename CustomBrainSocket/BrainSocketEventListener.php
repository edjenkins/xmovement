<?php
namespace CustomBrainSocket;

use Illuminate\Support\Facades\App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Comment;
use View;

use Auth;
use Config;
use Crypt;
use App\User;
use Illuminate\Session\SessionManager;


class BrainSocketEventListener extends \BrainSocket\BrainSocketEventListener implements MessageComponentInterface {


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

		if (!isset($idUser)) {
	        echo "the user is not logged via an http session";
	    } else {
	        $currentUser = User::find($idUser);
	    }

		$user_id = $currentUser->id;
		$text = json_decode($msg)->client->data->comment;
		$url = json_decode($msg)->client->data->url;
		$in_reply_to_comment_id = (json_decode($msg)->client->data->in_reply_to_comment_id) ? json_decode($msg)->client->data->in_reply_to_comment_id : NULL;

		if (json_decode($msg)->client->event == 'comment.posted')
		{
			$comment = Comment::create([
				'user_id' => $user_id,
				'text' => $text,
				'url' => $url,
				'in_reply_to_comment_id' => $in_reply_to_comment_id
			]);

			$numRecv = count($this->clients) - 1;
			echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
				, $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

			$res = json_decode($msg);
			$res->client->view = View::make('discussion.comment', ['comment' => $comment, 'authenticated_user' => $currentUser])->render();
			$msg = json_encode($res);

			foreach ($this->clients as $client) {
				$client->send($this->response->make($msg));
			}
		}
	}
}
