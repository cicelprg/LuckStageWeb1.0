<?php
namespace base;
require_once ('base/Registry.php');
use base\Registry;
/**
 * HTTP 请求注册表
 * @author prg
 */
class RequestRegistry extends Registry 
{
	
	private static $instance;
	/**
	 * 请求关联数组
	 * @var array
	 */
	private $values = array(); 
	
	private function __construct(){}
	
	static function instance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	protected function get($key)
	{
		if(isset($this->values[$key]))
		{
			return $this->values[$key];
		}
		return null;
	}
	
	protected function set($key,$val)
	{
		$this->values[$key] = $val;
	}
	
	/**
	 * 获取请求
	 * @return multitype:
	 */
	static  function getRequest()
	{
		return  self::instance()->get('request');
	}
	
	static function setRequest($request)
	{
		self::instance()->set('request', $request);
	}
}

?>