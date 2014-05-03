<?php
namespace command;

use base\request\Request;
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
			'SYS_DEFAULT'=>0,
			'SYS_ERROR_404'=>1,
			'SYS_ERROR_600'=>2,
			'SYS_SUCCESS'=>3
	);
	
	/**
	 * 当前命令执行状态
	 * @var int
	 */
	private $status = 0;
	
	/**
	 * 不能被重继承 保证每个命令实例都不带参数
	 */
	final function __construct(){}
	
	/**
	 * 执行命令
	 * @param Request $request
	 */
	function excute(Request $request){
		$request->setLastCommand($this);
		$this->status = $this->doExcute($request);
	}
	
	/**
	 * 将状态装换为对应的整形数据
	 * @param string $status_str
	 * @return multitype:number
	 */
	static function statusInt($statusStr = "SYS_DEFAULT"){
		if(empty($statusStr)||$statusStr==''){
			$statusStr = 'SYS_DEFAULT';
		}
		if(isset(self::$SYS_STATUS[$statusStr])){
			return self::$SYS_STATUS[$statusStr];
		}else{
			return self::$SYS_STATUS['SYS_DEFAULT'];
		}
	}
	
	/**
	 * 返回命令执行的状态
	 * @return number
	 */
	function  getStatus(){
		return $this->status;
	}
	
	/**
	 * 每次执行命令后返回一个执行状态
	 * @param string $str
	 */
	static function statuses($str='SYS_DEFAULT'){ 
		return self::statusInt($str);
	}
	
	/**
	 * 命令真正执行函数
	 * @param Request $request
	 * @return self::statuses()
	 */
	abstract function doExcute(Request $request);
}
?>