<?php
namespace controller;

require_once 'base/Request.php';
use base\Request;

require_once 'command/DefaultCommand.php';
use command\DefaultCommand;

require_once 'controller/controllerMap.php';
use controller\controllerMap;

/**
 * 应用控制器  FronController 将调用这个控制器来获取对应Command,将代替之前的CommandResolver
 * @author prg
 * @uses base\Request command\DefaultCommand controller\controllerMap
 */
class appController 
{
	private static $base_cmd;
	private static $default_cmd;
	private $controllerMap;
	
	/**
	 * 记录在单次http 请求中被请求的命令，防止死循环命令的发生
	 * @var unknown_type
	 */
	private $invoked = array(); 
	
	function __construct(controllerMap $map)
	{
		$this->controllerMap = $map;
		if(!isset(self::$base_cmd)||is_null(self::$base_cmd))
		{
			self::$base_cmd    = new \ReflectionClass("command\\Command");
			self::$default_cmd = new DefaultCommand(); 
		}
	}
	
	/**
	 * 获取命令执行后的view
	 * @param Request $req
	 * @return string
	 */
	function getView(Request $req)
	{
		$view = $this->getResource($req, 'View');
		return $view;
	}
	
	
	/**
	 * 获取跳转命令 
	 * @param Request $req
	 * @return string
	 */
	function getForward(Request $req)
	{
		$forward = $this->getResource($req, 'Forward');
		if(!is_null($forward))
		{
			//这里设定跳转命令到Request中 
		}
		return $forward;
	}
	
	/**
	 * 获取资源 ,根据命令字符串和相应的状态
	 * @param Request $request
	 * @param string $res(View,Forward,Classroot)
	 */
	function getResource(Request $req,$res)
	{
		//取得当前执行的命令
		$cmd    = @$req->getProperty('syscmd');
		
		//获取前一个命令对象，和执行状态
		$prveCmd    = $req->getLastCommand();
		$prveStatus = $prveCmd->getStatus();
		$acquire    = "get$res";
		
		//
		$resource   = $this->controllerMap->$acquire($cmd,$prveStatus); 
		
		
		//如果没有获取到对应命令且该状态下的对应资源
		
		
		///这里资源查找 还有待考虑
		//查找该命令下的默认状态资源
		if(is_null($resource))
		{
			$resource = $this->controllerMap->$acquire($cmd,0);
		}
		
		//这个状态下的默认资源
		if(!$resource)
		{
			$resource = $this->controllerMap->$acquire('default',$prveStatus);
		}
		
		//默认状态下的默认命令的资源 
		if(!$resource)
		{
			$resource = $this->controllerMap->$acquire('default',0);
		}
		
		return $resource;
	}
	
	/**
	 * 获取命令对象
	 * @param Request $req
	 * @return \command\DefaultCommand|NULL|OtherCommand
	 */
	function getCommand(Request $req)
	{
		// lastCommand 在Request 中初始化为 null
		$prevCmd = $req->getLastCommand();
		if(!$prevCmd)
		{
			//这是本次请求调用的第一个命令 
			$cmd = @$req->getProperty('syscmd');
			
			if(!$cmd)
			{
				//没有请求命令，使用默认命令并且返回默认状态 ,每个命令的默认状态时0,这里就是现实主页
				$req->setProperty('syscmd', 'default');
				return self::$default_cmd;
			}
		}
		else 
		{
			//之前已经执行过命令 要进行forward命令执行
			$cmd = $this->getForward($req);
			
			if(!$cmd)
			{
				//没有获取下一个命令
				return null;
			}
		}
		
		//解析这个cmd(可能是第一次请求命令,也可能是forward命令)命令名称 生成对应的OBJ
		$cmdObj = $this->resolveCommand($cmd);
		
		
		if(!$cmdObj)
		{
			//用户url 不正确提示404错误
			$req->setProperty('syscmd','default');
			
			//这里在Request里设定了一个status,在
			$req->setProperty('status', 'SYS_ERROR_404');
			
			return  self::$default_cmd;
		}
		
		$cmd_class = get_class($cmdObj);
		if(isset($this->invoked[$cmd_class]))
		{
			//在本次请求的时候这个命令已经执行过了  这是一个死循环命令,抛出系统级别错误
			echo $cmd,'是一个死循环命令';
			exit;
		}
		$this->invoked[$cmd_class] = 1;
		
		return $cmdObj;
	}
	
	/**
	 * 获取命令字符串对应的命令对象
	 * @param string $cmd
	 * @return \ReflectionClass|boolean
	 */
	private function resolveCommand($cmd)
	{
		//获取是否有映射命令
		$classroot = $this->controllerMap->getClassroot($cmd);
		
		$classroot = ucfirst($classroot);
		
		$filepath  = 'command\\'.$classroot.'Command.php';
		
		$className = "command\\$classroot".'Command';
		
		if(file_exists($filepath))
		{
			require_once "$filepath";
			if(class_exists($className))
			{
				$cmdObj = new \ReflectionClass($className);
				if($cmdObj->isSubclassOf(self::$base_cmd))
				{
					return $cmdObj->newInstance();
				}
			}
		}
		return false;
	}
}

?>