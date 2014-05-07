<?php

namespace command\user;
require_once 'base/session/SessionRegistry.php';
use base\session\SessionRegistry;

require_once 'command/Command.php';
use command\Command;

/**
 * 用户注销命令
 * @author prg
 * @copyright 2014-2015
 */
class LngoutCommand extends Command
{
	function doExcute(\base\request\Request $request){
		SessionRegistry::destroyUser();
		return self::statuses();
	}
}

?>