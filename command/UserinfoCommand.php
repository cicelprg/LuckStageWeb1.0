<?php

namespace command;

require_once 'base/SessionRegistry.php';
use base\SessionRegistry;

require_once 'base/Request.php';
use base\Request;

require_once ('command/CommandResolver.php');
use command\Command;
class UserinfoCommand extends command 
{
	function doExcute(Request $request)
	{
		if(SessionRegistry::getUser()=='')
		{
			//没有登录
			$request->setProperty('syscmd', 'login');
			return self::statuses();
		}
		return self::statuses();
	}
}

?>