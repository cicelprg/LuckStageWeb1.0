<?php

namespace base;

/**
 * 请求助手,用户解析url的，并且将对应的参数进行设置
 * @author prg
 */
class RequestHelper
{
	private $properties;
	static private $instance;
	private function __construct(){}
	
	static function instance()
	{
		if(!isset(self::$instance)||is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function init($request_uri)
	{
		//检查request_uri 是否包含命令
		
		if(strlen($request_uri)<=1) //这里表示浏览的是主页 
		{
			$this->setProperty('syscmd','default');
			return $this->properties;
		}
		//第一个字段用于表示命令 后面的都是参数,所有的命令用小写字母表示
		$cmdpattern = '/([a-zA-Z0-9]+)/';
		//var_dump($request_uri);
		$cmdRes= array(); 
		$res   = preg_match($cmdpattern, $request_uri,$cmdRes);
		if(!$res)
		{
			//这里表示非法命令 
			$this->setProperty('syscmd', 'default');
			return $this->properties;
		}
		
		if(isset($_SERVER['REQUEST_METHOD']))
		{
			//这里检查是否有有参数,如果有直接设置
			$_REQUEST['syscmd'] = $cmdRes[1];
			$this->properties   = $_REQUEST;
		}
		else
		{
			$this->properties['syscmd'] = $cmdRes[1];
			//脚本以命令行方式运行时
			
			foreach ($_SERVER['argv'] as $arg)
			{
				//argv 中第一个参数是文件名
				if(strpos($arg, '='))
				{
					list($key,$value) = explode('=', $arg);
					$this->setProperty($key, $value);
				}
			}
		}
		return $this->properties;
	}
	
	private function setProperty($key,$val)
	{
		$this->properties[$key] = $val;
	}
}
?>