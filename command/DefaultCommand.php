<?php

namespace command;
use base\Request;
require_once 'command/Command.php';
use command\Command;

/**
 * default Command 
 * @author prg
 */
class DefaultCommand extends Command
{
	function doExcute(Request $request)
	{
		return self::statuses($request->getProperty('status'));
	}
}

?>