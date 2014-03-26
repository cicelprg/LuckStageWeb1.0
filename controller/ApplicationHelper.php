<?php

namespace controller;

require_once 'command/Command.php';
use command\Command;

require_once 'base/ApplicationRegistry.php';
use base\ApplicationRegistry;

require_once 'controller/controllerMysql.php';

use controller\controllerMysql;

require_once 'controller/controllerMap.php';
use controller\controllerMap;

/**
 * 前端控制器 辅助类，用户获取配置信息、命令控制信息，如果缓存中没有那么将读取配置文件，
 * 并且缓存到文件中
 * @author prg
 * @uses command\Command
 * @uses base\ApplicationRegistry
 * @uses controller\controllerMysql;
 * @uses controller\controllerMap;
 * @copyright 2014-2015 
 */
class ApplicationHelper 
{
	private static $instance;
	private $config = './config/config.xml';
	private $xmlObj;
	private function __construct(){}
	
	
	static function instance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 初始化 
	 */
	public function init()
	{
		$this->ensure(file_exists($this->config), '配置文件不存!');
		$xmlfiletime = filemtime($this->config);
		//先从缓存获取配置信息
		$mysql = ApplicationRegistry::getMysql();
		
		//var_dump($mysql);
		if(is_null($mysql)||!ApplicationRegistry::checkCache('mysql',$xmlfiletime))//缓存中没有mysql有配置信息
		{
			$this->getMysqlOptions();
		}
		else
		{
			//echo 'get mysql from cache';
		}
		
		//get more options
		
		//controllerMap配置信息
		$controlllerMap = ApplicationRegistry::getControllerMap();
		
		if(is_null($controlllerMap)||!ApplicationRegistry::checkCache('controllerMap', $xmlfiletime))
		{
			$this->getContollerOptions();
		}
		else
		{
			//echo 'get map from cache';
		}
		
		
	}
	
	
	private function getMysqlOptions()
	{
		if(is_null($this->xmlObj))
		{
			$this->xmlObj = simplexml_load_file($this->config);
		}
		$Xmlmysql = $this->xmlObj->mysql;
		$mysql    = new controllerMysql();
		$this->ensure((string)$Xmlmysql->host, 'host not exist');
		$mysql->setHost((string)$Xmlmysql->host);
		$mysql->setUser((string)$Xmlmysql->user);
		$mysql->setPassword((string)$Xmlmysql->password);
		$mysql->setDB((string)$Xmlmysql->dbname);
		
		//缓存到文件中
		ApplicationRegistry::setMysql($mysql);
	}
	
	private function getContollerOptions()
	{
		if(is_null($this->xmlObj))
		{
			$this->xmlObj = simplexml_load_file($this->config);
		}
		
		//开始读取并配置controllerMap 

		$map = new controllerMap();
		//对全局视图的解析
		foreach ($this->xmlObj->control->view as $global_view)
		{
			//获取节点状态字符串
			$status_str=(string)$global_view['status'];
			if($status_str!='')
			{
				//转换为状态数字
				$status = Command::statusInt($status_str);
			}
			else
			{
				$status = 0; 
			}
			//获取对应的视图
			$view      = (string)$global_view;
			
			//添加到map中,全局中都用默认命令
			
			$map->addView('default',$status,$view);
		}
		//对命令的解析
		$status =0;
		foreach ($this->xmlObj->control->command as $command)
		{
			//对单个command命令的解析		
			
			//解析命令
			$cmdName=(string)$command['name'];
			
			//解析是否映射命令
			$classRoot = (string)$command->classroot['name'];
			//添加命令
			if($classRoot!='')
			{
				//添加映射命令
				$map->addClassroot((string)$command['name'], $classRoot);
			}
			
			//解析视图
			$view      = (string)$command->view;
			//解析视图状态
			$view_status_str = (string)$command->view['status'];
			if($view_status_str=='')
			{
				$status = 0;
			}
			else
			{
				$status = Command::statusInt($status_str);
			}
			//添加视图addView
			if($view!='')
			{
				$map->addView((string)$command['name'],$status,$view);
			}
			
			//解析forward 跳转命令
			$forwardStatus_str= (string)$command->status['value'];
			$forwardCommand   = (string)$command->status->forward;
		
			//添加forwardMap
			if($forwardStatus_str!=''&&$forwardCommand!='')
			{				
				$forwardStatusInt = Command::statusInt($forwardStatus_str);
				$map->addForward((string)$command['name'],$forwardStatusInt,$forwardCommand);
			}
		}
		
		ApplicationRegistry::setControllerMap($map);
	}
	
	
	private function ensure($expr,$msg)
	{
		if(!$expr)
		{
			echo 'ApplicationHelper Error',$msg;
			exit;
		}
	}
}


?>