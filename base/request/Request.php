<?php
namespace base\request;

require_once 'base/request/RequestHelper.php';
use base\request\RequestHelper;

require_once 'base/request/RequestRegistry.php';
use base\request\RequestRegistry;

/**
 * Http 请求都将封装到这个类
 * 并且设定 返回信息
 * @author prg
 */
class Request 
{
	/**
	 * 保存请求的参数和值 $name=>$value
	 * @var array
	 */
	private $properties;
	
	/**
	 * 保存最后一个命令 
	 * @var Command
	 */
	private $lastCommand = null;
	
	/**
	 * 保存当前请求命令
	 * @var string
	 */
	private $curCmdStr = 'default';

	/**
	 * 原始的请求url,$_SERVER['REQUEST_URL'];
	 * @var string
	 */
	private $requestUri = null;
	
	/**
	 * 请求方法
	 * @var string
	 */
	private $requestMethod = 'GET';
	
	/**
	 * 文件上传数组
	 * @var array
	 */
	private $files = null;
	
	/**
	 * 请求cookie值 暂时没做
	 * @var unknown_type
	 */
	private $cookie;
	
	/**
	 * 异常类
	 * @var \Exception
	 */
	private $exception;
	
	/**
	 * Requst Host
	 * @var string
	 */
	private $host;
	
	/**
	 * 初始化url
	 * @param string $request_uri
	 */
	function __construct(){
		RequestHelper::instance()->init($this);
		//Regist Request
		RequestRegistry::setRequest($this);
	}
	
	/**
	 * 设定请求参数
	 * @param string $key
	 * @param string $val
	 */
	function setProperty($key,$val){
		$this->properties[$key] = $val;
	}
	
	/**
	 * 根据请求参数获取参数值，请求命令不存在时返回 null
	 * @param string $key
	 * @return multitype:|NULL
	 */
	function getProperty($key){
		if(isset($this->properties[$key])){
			return $this->properties[$key];
		}
		return null;
	}
	
	/**
	 * 设置最后一次的命令
	 * @param Command $cmd
	 */
	function setLastCommand($cmd){
		$this->lastCommand = $cmd;		
	}
	
	/**
	 * 获取最后一次的命令
	 * @return \base\Command
	 */
	function getLastCommand(){
		return $this->lastCommand;
	}
	
	/**
	 * 设定当前命令
	 * @param string $str
	 */
	function setCurCmdStr($str='default'){
		$this->curCmdStr = $str;
	}
	
	/**
	 * 获取当前命令
	 * @return string
	 */
	function getCurCmdStr(){
		return $this->curCmdStr;
	}
	
	/**
	 * 设定原始请求路径
	 * @param string $uri
	 */
	function setRequestUri($uri){
		$this->requestUri = $uri;
	}
	
	/**
	 * 获取原始请求路径
	 * @return string
	 */
	function getRequestUri(){
		return $this->requestUri;
	}
	
	/**
	 * 设定请求方法
	 * @param string $method
	 */
	function setReqMethod($method='GET'){
		$this->requestMethod = $method;
	}
	
	/**
	 * 获取请求方式
	 * @return multitype:string
	 */
	function getReqMethod(){
		return $this->requestMethod;
	}
	
	/**
	 * 设定上传文件信息，是一个二维数组
	 * @param array $file
	 */
	function setFile(Array $file){
		$this->files[] = $file;
	}
	
	/**
	 * 返回包含文件信息的二维数组
	 * @return multitype:array
	 */
	function getFiles(){
		return $this->files;
	}
	/**
	 * 设置异常信息类
	 * @param \Exception $e
	 */
	function setExcetion(\Exception $e){
		$this->exception = $e;
	}
	
	/**
	 * 获取异常信息类
	 * @return Exception
	 */
	function getException(){
		return $this->exception;
	}
	/**
	 * 设定主机名
	 * @param string $host
	 * @return \base\request\Request
	 */
	function setHost($host="localhost"){
		$this->host = $host;
		return $this;
	}
	/**
	 * 获取主机名
	 * @return string
	 */
	function getHost(){
		return $this->host;
	}
	
	function setCookie(){}
	
	function getCookie(){}
}
?>