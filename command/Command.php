<?php
namespace command;

require_once 'base/Request.php';
use base\Request;

/**
 * Command 对象 不能处理太多的逻辑，只能够检查输入,
 * 处理错误，缓存对象，调用其他的对象来完成业务逻辑
 * @author prg
 * @uses  base\Request
 * @copyright 2014 - 2015 
 */
abstract class Command 
{
	
	/**
	 * 这里定义系统命令错误类型
	 */
	
	private static $SYS_STATUS = array
	(
			'SYS_DEFAULT_0'=>0,
			'SYS_ERROR_404'=>1,
			'SYS_ERROR_600'=>2,
			'SYS_SUCCESS_200'=>3
	);
	
	/**
	 * 当前命令执行状态
	 * @var int
	 */
	private $status = 0;
	
	final function __construct(){}
	
	function excute(Request $request)
	{
		//设定最后一次的访问命令 
		$request->setLastCommand($this);
		
		$this->status = $this->doExcute($request);
	}
	
	abstract function doExcute(Request $request);
	
	static function statusInt($status_str = "SYS_DEFAULT_0")
	{
		//var_dump($status_str);
		return self::$SYS_STATUS[$status_str];
	}
	
	/**
	 * 返回命令执行的状态
	 * @return number
	 */
	function  getStatus()
	{
		return $this->status;
	}
	
	static function statuses($str='SYS_DEFAULT_0')
	{ 
		if(empty($str))
		{
			$str = 'SYS_DEFAULT_0';
		}
		return self::$SYS_STATUS[$str];
	}
}
?>