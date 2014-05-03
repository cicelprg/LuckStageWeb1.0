<?php

namespace controller;

/**
 * 存储配置数据
 * @author prg
 */
class controllerMap 
{
	/**
	 * 映射命令 一维数组
	 * @var array
	 */
	private $classroot = array();

	/**
	 * 跳转命令存储,二位数组 
	 * @var array
	 */
	private $forwardMap= array();
	
	/**
	 * 视图存储，二位数组
	 * @var array
	 */
	private $viewMap   = array();
	
	/**
	 * 命令路径,一维数组
	 * @var array
	 */
	private $pathMap   = array();
	
	function __construct(){}
	
	/**
	 * 添加映射命令
	 * @param string $command
	 * @param string $classroot
	 */
	function addClassroot($command="default",$classroot){
		$command = $this->returnCmdStr($command);
		$this->classroot[$command] = $classroot;
	}
	
	/**
	 * 获取映射命令
	 * @param string $command
	 * @return string
	 */
	function getClassroot($command="default"){
		$command = $this->returnCmdStr($command);
		if(isset($this->classroot[$command])){
			return $this->classroot[$command];
		}
		return $command;//这里如果没有对应的映射 那么就直接返回本身，自己也是自己的映射
	}
	
	/**
	 * 添加跳转命令
	 * @param strng $command
	 * @param int $status
	 * @param string $forwardCommand
	 * @return \controller\controllerMap
	 */
	function addForward($command="default",$status=0,$forwardCommand){
		$command = $this->returnCmdStr($command);
		$this->forwardMap[$command][$status] = $forwardCommand;
		return $this;
	}
	
	/**
	 * 获取跳转命令
	 * @param string $command
	 * @param string $status
	 * @return NULL|string
	 */
	function getForward($command,$status){
		$command = $this->returnCmdStr($command);
		if(isset($this->forwardMap[$command][$status])){
			return $this->forwardMap[$command][$status];
		}
		return null;
	}
	
	/**
	 * 添加视图
	 * @param string $command
	 * @param int $status
	 * @param string $view
	 * @return \controller\controllerMap
	 */
	function addView($command='default',$status=0,$view){
		$command = $this->returnCmdStr($command);
		$this->viewMap[$command][$status] = $view;
		return $this;
	}
	
	/**
	 * 获取视图
	 * @param string $command
	 * @param int $status
	 * @return NULL|string
	 */
	function getView($command,$status){
		$command = $this->returnCmdStr($command);
		if(isset($this->viewMap[$command][$status])){
			return $this->viewMap[$command][$status];
		}
		return null;
	}
	/**
	 * 添加命令对应的路径
	 * @param string $command
	 * @param string $path
	 * @return \controller\controllerMap
	 */
	function addPath($command='default',$path='/'){
		$command = $this->returnCmdStr($command);
		if($path==''){
			$path = '/';
		}
		$this->pathMap[$command] = $path;
		return $this;
	}
	
	/**
	 * 获取命令路径
	 * @param string $command
	 * @return multitype:|NULL
	 */
	function getPath($command = "default"){
		$command = $this->returnCmdStr($command);
		if(isset($this->pathMap[$command])){
			return $this->pathMap[$command];
		}
		return null;
	}
	
	/**
	 * 处理命令字符串
	 * @param string $command
	 * @return string
	 */
	private function returnCmdStr($command){
		if($command==''){
			$command = 'default';
		}
		return $command;
	}
}

?>