<?php
namespace command\contact;

require_once 'base/session/SessionRegistry.php';
use base\session\SessionRegistry;

require_once ('command/CommandException.php');
use command\Command;

/**
 * 添加联系人命令
 * @author prg
 * @package command\contact
 * @copyright 2014-2015
 */
class AddcontactCommand extends command
{
	/**
	 * @see panret
	 * @param \base\request\Request $request
	 */
	function doExcute(\base\request\Request $request){
		$arr = array(
				);
		$User = SessionRegistry::getUser();
		if(!is_object($User)){
			
		}
		return self::statuses();
	}
}

?>