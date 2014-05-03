<?php
namespace base\response;
require_once 'base/response/ResponseRegisty.php';
use base\response\ResponseRegisty;

/**
 * 响应信息类,请求响应数据都在这里
 * @author prg
 * @copyright 2014 - 2015
 */
class Response
{
	/**
	 * 异常类
	 * @var \Exception
	 */
	private $excpetion = NULL;
	
	/**
	 * 请求响应数据 
	 * @var array
	 */
	private $dataArray=array();
	
	/**
	 * 返回信息
	 * @var array
	 */
	private $feedback =array();
	
	/**
	 * 实例化storage
	 */
	function __construct(){
		ResponseRegisty::setResponse($this);
		return $this;
	}
	
	/**
	 * 添加反馈信息
	 * @param string $msg
	 * @return \base\response\Response
	 */
	function addFeedBack($msg){
		$this->feedback[] = $msg; 
		return $this;
	}
	
	/**
	 * 回去反馈信息数组
	 * @return multitype:array
	 */
	function getFeedBack(){
		return $this->feedback;
	}
	
	/**
	 * 以字符串的形式获取反馈信息
	 * @param string $gule
	 * @return string
	 */
	function getFeedbackStr($gule="."){
		return implode($gule, $this->feedback);
	}
	
	/**
	 * 添加响应数据
	 * @param object|other $data
	 */
	function addData($key='default',$val=NULL){
		$this->dataArray[$key] = $val;
		return $this;
	}
	
	/**
	 * 获取整个数组
	 * @return multitype:array
	 */
	function getDataArray(){
		return $this->dataArray;
	}
	
	/**
	 * 获取响应数据
	 * @param string $key
	 * @return multitype:|NULL
	 */
	function getDataFromArray($key='default'){
		if(isset($this->dataArray[$key])){
			return $this->dataArray[$key];
		}
		return null;
	}
	
	/**
	 * 抛出异常类
	 * @param \Exception $e
	 * @return \base\response\Response
	 */
	function setException(\Exception $e){
		$this->excpetion = $e;
		return $this;
	}
	
	/**
	 * 获取异常类
	 * @return Exception
	 */
	function getException(){
		return $this->excpetion;
	}
}

?>