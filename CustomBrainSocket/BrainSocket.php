<?php
namespace CustomBrainSocket;

use Illuminate\Console\Command;

class BrainSocket extends \BrainSocket\BrainSocket {

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$port = $this->option('port');

		$server = new BrainSocketServer();
		$server->start($port);
		$server->run();
	}

}
