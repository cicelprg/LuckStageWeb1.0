<?php

namespace base;

require_once ('base/Registry.php');

use base\Registry;

/**
 * 会话注册表
 * @author prg
 */
class SessionRegistry extends Registry 
{
	private static $instance;
	
	private function __construct()
	{
		ob_start();
		ob_clean();
		session_start();
	}
	
	static function instance()
	{
		if(!isset(self::$instance))
		{
			self::$instance=new self();
		}
		return self::$instance;
	}
	
	protected function get($key)
	{
		return isset($_SESSION[__CLASS__][$key])?$_SESSION[__CLASS__][$key]:null;
	}
	
	protected function set($key, $val)
	{
		$_SESSION[__CLASS__][$key] = $val;
	}
	
	/**
	 * 获取用户
	 */
	static function getUser()
	{
		return self::instance()->get('User');
	}
	
	/**
	 * 设定用户
	 */
	static function setUser($val)
	{
		self::instance()->set('User', $val);
	}
}

?>