<?php

namespace command;


require_once ('command/Command.php');

use command\Command;

use base\Request;

class IndexCommand extends Command 
{

	function doExcute(Request $request)
	{
		$request->setProperty('location', 'views/index.html');
	}
}

?>