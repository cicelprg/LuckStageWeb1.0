<?php

namespace base\session;

require_once ('base/Registry.php');

use base\Registry;

/**
 * 会话注册表
 * @author prg
 */
class SessionRegistry extends Registry 
{
	private static $instance;
	
	private function __construct(){
		ob_start();
		ob_flush();
		ob_clean();
		session_start();
	}
	
	/**
	 * 获取单例
	 * @return \base\session\SessionRegistry
	 */
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance=new self();
		}
		return self::$instance;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \base\Registry::get()
	 */
	protected function get($key){
		return isset($_SESSION[__CLASS__][$key])?unserialize($_SESSION[__CLASS__][$key]):null;
	}
	/**
	 * (non-PHPdoc)
	 * @see \base\Registry::set()
	 */
	protected function set($key, $val){
		$_SESSION[__CLASS__][$key] = serialize($val);
	}
	
	/**
	 * 销毁一个session值
	 * @param string $key
	 */
	protected function destroy($key){
		unset($_SESSION[__CLASS__][$key]);
	}
	/**
	 * 获取用户
	 */
	static function getUser(){
		return self::instance()->get('User');
	}
	
	/**
	 * 设定用户
	 */
	static function setUser($val){
		self::instance()->set('User', $val);
	}
	/**
	 * 注销用户
	 */
	static function destroyUser(){
		self::instance()->destroy('User');
	}
}

?>