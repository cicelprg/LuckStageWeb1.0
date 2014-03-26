<?php

namespace base;

require_once 'controller/appController.php';
use controller\appController;

require_once ('base/Registry.php');

use base\Registry;

/**
 * 应用程序注册表,这个类主要功能:获取程序配置数据 和缓存程序配置数据
 * (包括数据库配置，和appController中的命令配置)
 * @author prg
 * @uses appController
 */
class ApplicationRegistry extends Registry 
{
	
	private static $instance;
	
	/**
	 * 数据缓存文件路劲
	 * @var string
	 */
	private $dir   = 'appData';
	
	private $values= array();
	
	private $mtimes= array(); 
	
	private function __construct(){}
	
	static  function instance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	protected function get($key)
	{
		$path = $this->dir.DIRECTORY_SEPARATOR.$key;
		if(file_exists($path))
		{
			clearstatcache();
			$mtime = filemtime($path);
			if(!isset($this->mtimes[$key]))
			{
				$this->mtimes[$key] = 0;
			}
			
			if($mtime>$this->mtimes[$key])
			{
				$data = file_get_contents($path);
				$this->mtimes[$key] = $mtime;
				return ($this->values[$key]=unserialize($data));
			}
			
		}
		return isset($this->values[$key])?$this->values[$key]:null;
	}
	
	protected function set($key, $val)
	{
		$this->values[$key] = $val;
		$this->mtimes[$key] = time();
		$path = $this->dir.DIRECTORY_SEPARATOR.$key;
		file_put_contents($path, serialize($val));
	}
	
	/**
	 * 检查缓存是否过期
	 * @param string $key
	 * @param int $time
	 */
	static function checkCache($key,$time)
	{
		$path = 'appData'.DIRECTORY_SEPARATOR.$key;
		if(file_exists($path))
		{
			$cahefiletime = filemtime($path);
			if($time<$cahefiletime)
			{
				//缓存没有过期
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 设定 mysql 数据配置
	 * @param controllerMysql $mysql
	 */
	static function setMysql($mysql)
	{
		self::instance()->set('mysql',$mysql);
	}
	
	static function getMysql()
	{
		return self::instance()->get('mysql');
	}
	
	/**
	 * 设定 app cmd 数据配置
	 * @param controllerMap $val
	 */
	static function setControllerMap($val)
	{
		self::instance()->set('controllerMap', $val);
	}
	
	static function getControllerMap()
	{
		return self::instance()->get('controllerMap');
	}
	
	
	/**
	 * 获取appController
	 * @return \controller\appController
	 */
	static function appController()
	{
		return new appController(self::getControllerMap());
	}
}

?>