<?php
namespace command\user;
require_once 'base/session/SessionRegistry.php';
use base\session\SessionRegistry;

use domain\factory\Helpfactory;
require_once ('command/Command.php');

require_once 'mapper/mappers/AddressBookMapper.php';
use \mapper\mappers\AddressBookMapper;

use command\Command;
use base\request\Request;

/**
 * 提取用户的联系人信息
 * @author prg
 * @copyright 2014-2015
 */
class ShowcontactsCommand extends Command
{
	function doExcute(Request $request){
		$user    = SessionRegistry::getUser();
		if(!is_object($user)){
			return self::statuses('SYS_ERROR_600');
		}
		$mapper  = Helpfactory::getMapper("\\mapper\\mappers\\AddressBookMapper");
		$collection = $mapper->findByUser($user);
		\base\response\ResponseRegisty::getResponse()->addData('addressBooks',$collection);
		return self::statuses();
	}
}
?>