<?php
namespace base;

require_once ('base/RequestRegistry.php');
use base\RequestRegistry;

require_once 'base/RequestHelper.php';
use base\RequestHelper;

/**
 * Http 请求都将封装到这个类
 * 并且设定 返回信息
 * @author prg
 */
class Request 
{
	/**
	 * 保存请求的参数和值
	 * @var array
	 */
	private $properties;
	
	/**
	 * 保存返回信息
	 * @var array
	 */
	private $feedback =array();
	
	/**
	 * 保存最后一个命令 
	 * @var Command
	 */
	private $lastCommand = null;
	
	function __construct($request_uri)
	{
		$this->init($request_uri);
		//将请求类注册到注册表中
		RequestRegistry::setRequest($this);
	}
	
	/**
	 * 初始化,获取请求参数
	 */
	function init($request_uri)
	{
		$this->properties = RequestHelper::instance()->init($request_uri);
	}
	
	/**
	 * 设定请求参数
	 * @param string $key
	 * @param string $val
	 */
	function setProperty($key,$val)
	{
		$this->properties[$key] = $val;
	}
	
	/**
	 * 根据请求参数获取参数值，请求命令不存在时返回 null
	 * @param string $key
	 * @return multitype:|NULL
	 */
	function getProperty($key)
	{
		if(isset($this->properties[$key]))
		{
			return $this->properties[$key];
		}
		return null;
	}
	
	/**
	 * 添加返回信息
	 * @param string $msg
	 */
	function addFeedback($msg)
	{
		array_push($this->feedback, $msg);
	}
	
	/**
	 * 获取返回信息数组
	 * @return multitype:
	 */
	function getFeedback()
	{
		return $this->feedback;
	}
	
	/**
	 * 返回反馈信息字符串
	 * @param string $separator
	 * @return string
	 */
	function getFeedbackString($separator="\n")
	{
		return implode($separator, $this->feedback);
	}
	
	/**
	 * 设置最后一次的命令
	 * @param Command $cmd
	 */
	function setLastCommand($cmd)
	{
		$this->lastCommand = $cmd;		
	}
	
	/**
	 * 获取最后一次的命令
	 * @return \base\Command
	 */
	function getLastCommand()
	{
		return $this->lastCommand;
	}
}
?>