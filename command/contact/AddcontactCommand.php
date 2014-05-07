<?php
namespace command\contact;

require "domain/factory/Helpfactory.php";
use domain\factory\Helpfactory;

require_once 'base/session/SessionRegistry.php';
use base\session\SessionRegistry;

require_once ('command/Command.php');
use command\Command;

require_once 'mapper/mappers/UserMapper.php';
use \mapper\mappers\UserMapper;

require_once 'mapper/mappers/AddressBookMapper.php';
use \mapper\mappers\AddressBookMapper;

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
				'tel'=>$request->getProperty('tel')
				);
		$User = SessionRegistry::getUser();
		if(!is_object($User)){
			return self::statuses('SYS_ERROR_600');
		}else{
			//check data 
			$response = \base\response\ResponseRegisty::getResponse();
			if($arr['tel']==''){
				$response->addFeedback('请输入电话号码');
				return self::statuses();
			}else{
				$addressMapper = Helpfactory::getMapper("\\mapper\\mappers\\AddressBookMapper");
				$arr['uid']    = $User->getID();
				try{
					$addressMapper->insert($addressMapper->createObject($arr));
				}catch(\mapper\MapperException $me){
					$response->setException($me);
					echo $me;
					return self::statuses();
				}
				return self::statuses('SYS_SUCCESS');
			}
		}
		return self::statuses();
	}
}

?>