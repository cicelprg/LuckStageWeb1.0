<?php

namespace controller;
require_once 'base/response/Response.php';
use base\response\Response;

require_once 'base/request/Request.php';
use base\request\Request;

require_once 'base/ApplicationRegistry.php';
use base\ApplicationRegistry;

require_once 'controller/ApplicationHelper.php';
use controller\ApplicationHelper;

use base\BaseException;

/**
 * 前端控制器,应用程序入口
 * @author prg
 * @uses base\ApplicationRegistry base\Request controller\ApplicationHelper
 */
class FrontController 
{
	/**
	 * 应用程序助手类,获取应用程序配置信息
	 * @var base\ApplicationHelper
	 */
	private $applicationHelper;
	
	/**
	 * 禁止实例化
	 */
	private function __construct(){}
	
	/**
	 * 运行程序
	 */
	static function run(){
		$instance = new self();
		$instance->init();
		$instance->handlRequest();
	}
	
	/**
	 * 初始化配置数据
	 */
	public function init(){
		$this->applicationHelper=ApplicationHelper::instance();
		try {
			$this->applicationHelper->init();
		}catch(BaseException $be){
			echo $be;
			exit;
		}
	}
	
	/**
	 * 真正执行
	 */
	function handlRequest(){
		$request= new Request();
		new Response();
		$appc    = ApplicationRegistry::appController(); 
		$cmd = $appc->getCommand($request);	
		while(!is_null($cmd)){
			$cmd->excute($request);	
			$cmd = $appc->getCommand($request);
		}
		try{
			$this->invokeView($appc->getView($request));
		}catch (ApplicationException $ae){
			echo $ae;//--debug
			include 'views/systemError.php';
		}
	}
	/**
	 * 导入视图
	 * @param string $view
	 * @throws ApplicationException
	 */
	function invokeView($view){
		if(file_exists('views'.$view)){
			include 'views'.$view;
		}
		else{
			throw new ApplicationException('没有找到对应的视图文件');
		}
	}
}

?>