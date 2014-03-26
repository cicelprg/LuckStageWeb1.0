<?php

namespace controller;

require_once 'base/ApplicationRegistry.php';
use base\ApplicationRegistry;

//require_once 'command/CommandResolver.php';
//use command\CommandResolver;

require_once 'base/Request.php';
use base\Request;

require_once 'controller/ApplicationHelper.php';
use controller\ApplicationHelper;

/**
 * 前端控制器,应用程序同一入口
 * @author prg
 * @uses base\ApplicationRegistry base\Request controller\ApplicationHelper
 */
class FrontController 
{
	private $applicationHelper;
	
	private function __construct(){}
	
	static function run()
	{
		$instance = new FrontController();
		$instance->init();
		$instance->handlRequest();
	}
	
	public function init()
	{
		$this->applicationHelper=ApplicationHelper::instance();
		$this->applicationHelper->init();
	}
	
	function handlRequest()
	{
		//封装 Request 对象
		$request= new Request($_SERVER['REQUEST_URI']);
		
		//获取appController 并且调用ApplicationRegistry 获取了 controllerMap 信息
		$appc    = ApplicationRegistry::appController(); 
		
		$cmd = $appc->getCommand($request);
		//exit;
		//var_dump($request,$cmd);
		//exit;
		while($cmd)
		{
			$cmd->excute($request);
			///var_dump($request,$cmd);
			//exit;
			//exit;
			$cmd = $appc->getCommand($request);
		}
		
		//exit;
		echo $request->getFeedbackString();
		$this->invokeView($appc->getView($request));
		
	}
	
	function invokeView($view)
	{
		if(file_exists('views/'.$view))
		{
			include 'views/'.$view;
		}
		else
		{
			echo 'no view---'.$view;
		}
		exit;
	}
}

?>