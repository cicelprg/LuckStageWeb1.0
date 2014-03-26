<?php

namespace command;

require_once 'base\SessionRegistry.php';
use base\SessionRegistry;

require_once 'base/Request.php';
use base\Request;

require_once ('command/Command.php');

use command\Command;

class LoginCommand extends Command {
	
	/**
	 * (non-PHPdoc)
	 * @see \command\Command::doExcute()
	 */
	function doExcute(Request $request)
	{
		// 验证信息进行登录
		//$request->setProperty('location', 'views/login.html');
		if(@$request->getProperty('user')==123&&@$request->getProperty('password')==123)
		{
			//注册session变量
			SessionRegistry::setUser($request->getProperty('user'));
			
			//var_dump(SessionRegistry::getUser());
			//exit;
			$request->setProperty('syscmd', 'userinfo');
			return self::statuses('SYS_SUCCESS_200');
		}
		elseif(@$request->getProperty('user')==''||@$request->getProperty('password')=='')
		{
			$request->addFeedback('请输入密码或者是用户名');
			return self::statuses('SYS_DEFAULT_0');
		}
		else 
		{
			$request->addFeedback('用户名和密码不匹配');
			return self::statuses('SYS_DEFAULT_0');
		}
		
	}
}

?>