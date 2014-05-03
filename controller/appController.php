<?php
namespace controller;
require_once 'controller/ApplicationException.php';
use controller\ApplicationException;
use base\request\RequestException;
use command\Command;
require_once 'command/DefaultCommand.php';
use command\DefaultCommand;
use controller\controllerMap;
use base\request\Request;

/**
 * 应用控制器  FronController 将调用这个控制器来获取对应Command,将代替之前的CommandResolver
 * @author prg
 * @uses base\Request command\DefaultCommand controller\controllerMap
 */
class appController 
{
	/**
	 * 基础命令
	 * @var command\Command
	 */
	private static $baseCmd;
	
	/**
	 * 默认命令
	 * @var command\DefaultCommand
	 */
	private static $defaultCmd;
	
	/**
	 * 命令控制器
	 * @var controllerMap
	 */
	private $controllerMap;
	
	/**
	 * 记录在单次http 请求中被请求的命令，防止死循环命令的发生
	 * @var array
	 */
	private $invoked = array(); 
	
	/**
	 * 初始化
	 * @param controllerMap $map
	 */
	function __construct(controllerMap $map){
		$this->controllerMap = $map;
		if(!isset(self::$baseCmd)||is_null(self::$baseCmd)){
			self::$baseCmd    = new \ReflectionClass("command\\Command");
			self::$defaultCmd  = new DefaultCommand(); 
		}
	}
	
	/**
	 * 获取命令执行后的view
	 * @param Request $req
	 * @return string
	 */
	function getView(Request $req){
		$view = $this->getResource($req, 'View');
		return $view;
	}
	
	/**
	 * 获取跳转命令 
	 * @param Request $req
	 * @return string
	 */
	function getForward(Request $req){
		$forward = $this->getResource($req, 'Forward');		
		if(!is_null($forward)){
			$req->setCurCmdStr($forward);
		}
		return $forward;
	}
	
	/**
	 * 获取资源 ,根据命令字符串和相应的状态
	 * @param Request $request
	 * @param string $res(View,Forward,Classroot)
	 */
	function getResource(Request $req,$res){
		$prveCmd    = $req->getLastCommand();//获取前一个命令对象
		$prveStatus = $prveCmd->getStatus();
		$ref = new \ReflectionClass(get_class($prveCmd));
		$cmd = $ref->getShortName();
		$cmd = strtolower(str_replace('Command', '', $cmd));
		$acquire    = "get$res";
		$resource   = $this->controllerMap->$acquire($cmd,$prveStatus);//查找对应的资源
		return $resource;
	}
	
	/**
	 * 获取命令对象
	 * @param Request $req
	 * @return \command\DefaultCommand|NULL|OtherCommand
	 */
	function getCommand(Request $req){
		$prevCmd = $req->getLastCommand();
		if(is_null($prevCmd)){
			$cmd = $req->getCurCmdStr(); //first request
			if($cmd==''||$cmd=='default'){
				$req->setCurCmdStr();
				return self::$defaultCmd;
			}
		}
		else {
			$cmd = $this->getForward($req);//get forward command
			if(!$cmd){
				return null;
			}
		}
		$cmdObj = $this->resolveCommand($cmd); //实例化命令
		if(!$cmdObj){
			\base\response\ResponseRegisty::getResponse()->setException(new RequestException("Sorry! We Can't Find The Page! Please Try Again"));//404 error
			return self::$defaultCmd;
		}
		$cmd_class = get_class($cmdObj);
		if(isset($this->invoked[$cmd_class])){//在本次请求的时候这个命令已经执行过了 这是一个死循环命令,抛出系统级别错误
			throw new ApplicationException('Sorry!系统错误,我们会尽快修复!');
		}
		$this->invoked[$cmd_class] = 1;
		return $cmdObj;
	}
	
	/**
	 * 获取命令字符串对应的命令对象
	 * @param string $cmd
	 * @return \ReflectionClass|boolean
	 */
	private function resolveCommand($cmd){
		$classroot = $this->controllerMap->getClassroot($cmd);//获取是否有映射命令
		$path      = $this->controllerMap->getPath($cmd);
		$classroot = ucfirst($classroot);
		$filepath  = 'command'.$path.$classroot.'Command.php';
		$className = 'command'.$path.$classroot.'Command';
		$className = str_replace('/', '\\', $className);
		if(file_exists($filepath)){
			require_once "$filepath";
			if(class_exists($className)){
				$cmdObj = new \ReflectionClass($className);
				if($cmdObj->isSubclassOf(self::$baseCmd)){
					return $cmdObj->newInstance();
				}
			}
		}
		return false;
	}
}
?>