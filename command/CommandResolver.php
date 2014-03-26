<?php

namespace command;
require_once 'base/Request.php';
use base\Request;

require_once 'command/DefaultCommand.php';
use command\DefaultCommand;

/**
 * 根据URL 来确定调用哪个命令，也是命令的生成者，
 * 生成的命令将在前端控制器中使用
 * 已经弃用 代替的是appCongtroller 应用控制器
 * @author prg
 * @uses base\Request
 * @uses command\DefaultCommand
 * @copyright 2014-2015
 */
class CommandResolver 
{
	private static $base_cmd;
	private static $default_cmd;
	
	function __construct()
	{
		if(!isset(self::$base_cmd)||is_null(self::$base_cmd))
		{
			self::$base_cmd    = new \ReflectionClass("command\\Command");
			self::$default_cmd = new DefaultCommand();
		}
	}
	
	function getCommand(Request $request)
	{
		$cmd = @$request->getProperty('syscmd');
		$sep = DIRECTORY_SEPARATOR;
		
		if(is_null($cmd)) //检查命令   
		{
			echo 'cmd is not exist';
			//没有对应的命令就返回基础默认命令
			//return self::$default_cmd；
			exit;
		}
		
		$cmd = ucfirst($cmd);
		
		//这里开始获取相应的Command
		$cmdPath  = 'command/'.$cmd.'Command.php';
		$className= $cmd.'Command';
		
		if(!file_exists($cmdPath)) //这里对应命令文件是否存在 命令错误
		{
			//echo 'no',$cmd,'Command file<br/>';
			//这里跳转到404 页面
			$cmd = 'Error';
			$cmdPath  = 'command/'.$cmd.'Command.php';
			$className= $cmd.'Command';
			//exit;
		}
		
		$namespace = "command\\$className";
		//var_dump($cmdPath,$className,$namespace);
		//exit;
		require_once ("$cmdPath");
		
		if(!class_exists($namespace)) //这里检查对应的命令的类是否存在  这里是系统内部错误
		{
			echo 'no',$className;
			exit;
		}
		
		$cmdClass = new \ReflectionClass($namespace);
		
		if($cmdClass->isSubClassOf(self::$base_cmd)) //这里看看是否是继承与基类
		{
			return $cmdClass->newInstance();
		}
		else
		{
			echo $className,'is not subofCommand <br/>';
			exit;
		}
	}
}

?>