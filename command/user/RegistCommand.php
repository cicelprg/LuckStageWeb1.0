<?php
namespace command\user;
require_once 'base\session\SessionRegistry.php';
use base\session\SessionRegistry;

require_once 'domain/factory/Helpfactory.php';
use domain\factory\Helpfactory;

require_once ('command/CommandException.php');
use command\Command;

require_once 'mapper/mappers/UserMapper.php';
use mapper\mappers\UserMapper;

/**
 * 用户注册命令类
 * @author prg
 * @package command\user
 * @uses command\Command;
 * @copyright 2014 -2015
 */
class RegistCommand extends command
{
	/**
	 * @see parent 
	 * @param \base\request\Request $request
	 */
	function doExcute(\base\request\Request $request){
		$arr = array(
					'uname'=>$request->getProperty('user'),
					'upwd' =>$request->getProperty('password'),
					'repwd'=>$request->getProperty('repassword')
				);
		if($arr['uname']==''||$arr['upwd']==''||$arr['repwd']==''){
			\base\response\ResponseRegisty::getResponse()->addFeedback('信息没有填写完整');
			return self::statuses();
		}else if($arr['upwd']!=$arr['repwd']){
			\base\response\ResponseRegisty::getResponse()->addFeedback('两次密码不一样');
			return self::statuses();
		}else{
			$UserMapper = Helpfactory::getMapper("\\mapper\\mappers\\UserMapper");
			$User     = $UserMapper->createObject($arr);
			$isRegist = $UserMapper->findIdByName($User->getUserName());
			if(!is_null($isRegist)){
				\base\response\ResponseRegisty::getResponse()->addFeedback('该用户名已经被使用');
			}
			else{
				$UserMapper->insert($User);
				SessionRegistry::setUser($User);
				return self::statuses('SYS_SUCCESS');
			}
			return self::statuses();
		}
	}
}

?>