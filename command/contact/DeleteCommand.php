<?php

namespace command\contact;
use base\response\ResponseRegisty;
require_once 'domain/factory/Helpfactory.php';
use domain\factory\Helpfactory;
require_once 'base/session/SessionRegistry.php';
use base\session\SessionRegistry;

require_once 'domain/domains/User.php';
use \domain\domains\User;

require_once ('command/Command.php');
use \command\Command;

require_once('mapper/mappers/AddressBookMapper.php');
use \mapper\mappers\AddressBookMapper;


class DeleteCommand extends command
{
	function doExcute(\base\request\Request $request){
		$arr = array('address_id'=>$request->getProperty('address_id'));
		$response = ResponseRegisty::getResponse();
		if($arr['address_id']==''){
			$response->addFeedback('没有要删除的数据');
			return self::statuses();
		}
		$User = SessionRegistry::getUser();
		if(!is_object($User)){
			return self::statuses('SYS_ERROR_600');
		}else{
			$addressMapper = Helpfactory::getMapper("\\mapper\\mappers\\AddressBookMapper");
			try {
				$res = $addressMapper->delete($addressMapper->createObject($arr));
				
			}catch (\mapper\MapperException $me){
				echo $me;
				$response->addFeedback('删除的内容不存在');
				return self::statuses(); 
			}
			return self::statuses('SYS_SUCCESS');
		}
		return self::statuses();
	}
}
?>