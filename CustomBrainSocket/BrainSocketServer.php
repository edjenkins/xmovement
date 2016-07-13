<?php
namespace CustomBrainSocket;

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;

class BrainSocketServer{
	protected $server;

	public function start($port){
		$this->server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new \CustomBrainSocket\BrainSocketEventListener(//new \App\Http\Controllers\BrainSocketController(
						new \BrainSocket\BrainSocketResponse(new \BrainSocket\LaravelEventPublisher())
					)
				)
			)
			, $port
		);
	}

	public function run(){
		$this->server->run();
	}

}
