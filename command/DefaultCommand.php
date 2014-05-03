<?php
namespace command;
use base\request\RequestException;
use base\response\ResponseRegisty;
use base\request\Request;
require_once 'command/Command.php';
use command\Command;

/**
 * default Command 
 * @author prg
 */
class DefaultCommand extends Command
{
	function doExcute(Request $request){
		if($request->getException()!= NULL||ResponseRegisty::getResponse()->getException() instanceof RequestException){
			return self::statuses('SYS_ERROR_404');
		}
		return self::statuses();
	}
}

?>