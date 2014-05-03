<?php

namespace command\user;
use base\response\ResponseRegisty;
require_once 'domain/factory/Helpfactory.php';
use domain\factory\Helpfactory;

require_once 'mapper/mappers/UserMapper.php';
use mapper\mappers\UserMapper;

require_once 'base/session/SessionRegistry.php';
use base\session\SessionRegistry;

require_once ('command/Command.php');
use command\Command;
use base\request\Request;

class LoginCommand extends Command
{
	
	/**
	 * (non-PHPdoc)
	 * @see \command\Command::doExcute()
	 */
	function doExcute(Request $request){
		
		$arr        = array('uname'=>$request->getProperty('user'),
							'upwd'=>$request->getProperty('password')
		);
		if($arr['uname']=='' ||$arr['upwd']==''){
			return self::statuses();
		}
		$userCollection = Helpfactory::getCollection("\\mapper\\collections\\UserCollerction",new UserMapper());	
		$res = $userCollection->getMapper()->checkUser($arr);
		if(is_bool($res)){
			ResponseRegisty::getResponse()->addFeedBack('用户名和密码不匹配');
			return self::statuses();
		}else{
			$userObj = $userCollection->getMapper()->createObject($res);
			$userCollection->add($userObj);
			SessionRegistry::setUser($userObj);
			return self::statuses('SYS_SUCCESS');
		}
	}
}

?>