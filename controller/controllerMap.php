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
	
	function addClassroot($command,$classroot)
	{
		@$this->classroot[$command] = $classroot;
	}
	
	function getClassroot($command)
	{
		if(isset($this->classroot[$command]))
		{
			return $this->classroot[$command];
		}
		//这里如果没有对应的映射 那么就直接返回本身，自己也是自己的映射
		return $command;
	}
	
	function addForward($command="default",$status=0,$forwardCommand)
	{
		@$this->forwardMap[$command][$status] = $forwardCommand;
	}
	
	function getForward($command,$status)
	{
		if(isset($this->forwardMap[$command][$status]))
		{
			return $this->forwardMap[$command][$status];
		}
		return null;
	}
	
	function addView($command='default',$status=0,$view)
	{
		@$this->viewMap[$command][$status] = $view;
	}
	
	function getView($command,$status)
	{
		if(isset($this->viewMap[$command][$status]))
		{
			return $this->viewMap[$command][$status];
		}
		return null;
	}
}

?>