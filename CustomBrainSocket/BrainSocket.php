<?php
namespace CustomBrainSocket;

use Illuminate\Console\Command;

use Log;

class BrainSocket extends \BrainSocket\BrainSocket {

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$connection =  @socket_connect($socket, $_SERVER['HTTP_HOST'], 8080);
		socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 1, 'usec' => 0));
		socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 1, 'usec' => 0));

		if (!$connection )
		{
		    $port = $this->option('port');

			$server = new BrainSocketServer();
			$server->start($port);
			$server->run();
		}
	}
}
