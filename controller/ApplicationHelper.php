<?php
namespace controller;
require_once 'base/BaseException.php';
use base\BaseException;

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
	
	/**
	 * 配置文件路劲 这里是硬编码
	 * @var string
	 */
	private $config = './config/config.xml';
	
	/**
	 * xml Object
	 * @var Object
	 */
	private $xmlObj;
	
	/**
	 * 禁止实例化
	 */
	private function __construct(){}
	
	/**
	 * 获取单例对象
	 * @return \controller\ApplicationHelper
	 */
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 初始化 
	 */
	public function init(){
		$this->ensure(file_exists($this->config), '对不起,配置文件不存!');
		$xmlfiletime = filemtime($this->config);
		if(ApplicationRegistry::checkCache('mysql',$xmlfiletime)){
			$mysql = ApplicationRegistry::getMysql();//从缓存获取MYSQL配置信息
		}else{
			$this->getMysqlOptions();
		}
		if(ApplicationRegistry::checkCache('controllerMap', $xmlfiletime)){
			$controlllerMap = ApplicationRegistry::getControllerMap();
		}else{
			$this->getContollerOptions();
		}
	}
	
	/**
	 * 获取mysql 结点配置信息
	 * 并缓存起来
	 */
	private function getMysqlOptions(){
		if(is_null($this->xmlObj)){
			$this->xmlObj = simplexml_load_file($this->config);
		}
		$Xmlmysql = $this->xmlObj->mysql;
		$mysql    = new controllerMysql();
		$this->ensure((string)$Xmlmysql->host, '程序初始化失败---debug 主机不存在');
		$mysql->setDrive((string)$Xmlmysql->drive);
		$mysql->setHost((string)$Xmlmysql->host);
		$mysql->setUser((string)$Xmlmysql->user);
		$mysql->setPassword((string)$Xmlmysql->password);
		$mysql->setDB((string)$Xmlmysql->dbname);
		//缓存到文件中
		ApplicationRegistry::setMysql($mysql);
	}
	
	/**
	 * 获取control结点配置信息，并缓存
	 * 
	 */
	private function getContollerOptions(){
		if(is_null($this->xmlObj)){
			$this->xmlObj = simplexml_load_file($this->config);
		}
		$map = new controllerMap();
		//GLOBAL Views
		foreach ($this->xmlObj->control->view as $global_view){
			$status_str=(string)$global_view['status'];
			if($status_str!=''){
				$status = Command::statusInt($status_str);//转换为状态数字
			}
			else{
				$status = 0;//default
			}
			$map->addView('default',$status,(string)$global_view);//全局视图对应的命令为 default
		}
		//对命令的解析
		$status =0;
		foreach ($this->xmlObj->control->command as $command){
			$cmdName=(string)$command['name'];
			$classRoot = (string)$command->classroot['name'];//解析是否映射命令
			if($classRoot!=''){
				$map->addClassroot((string)$command['name'], $classRoot);//添加映射命令
			}
			foreach ($command->view as $v){
				$status_str = (string)$v['status'];//解析视图状态
				if($status_str==''){
					$status = 0;//default
				}
				else{
					$status = Command::statusInt($status_str);
				}
				if($v!=''){
					$map->addView((string)$command['name'],$status,(string)$v);//添加视图addView
				}
			}
			//解析forward 跳转命令根据命令不同的状态可能有多个跳转命令
			$forwardStatus = $command->status;
			foreach ($forwardStatus as $forwardSta){
				
				$status_str = (string)$forwardSta['value'];
				$forwardCmd = (string)$forwardStatus->forward;
				$status     = Command::statusInt($status_str);
				$map->addForward((string)$command['name'],$status,$forwardCmd);
			}
			//添加path
			$map->addPath((string)$command['name'],(string)$command->path);
			
		}
		//cache the map
		ApplicationRegistry::setControllerMap($map);
	}
	
	/**
	 * 确认信息是否存在
	 * @param bool $expr
	 * @param string $msg
	 * @throws BaseException
	 */
	private function ensure($expr,$msg){
		if(!$expr){
			throw new BaseException($msg);
		}
	}
}
?>