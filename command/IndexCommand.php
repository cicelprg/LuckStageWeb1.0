<?php
namespace command;
require_once ('command/Command.php');
use command\Command;
use base\request\Request;

class IndexCommand extends Command 
{
	function doExcute(Request $request){
		return self::statuses();
	}
}
?>