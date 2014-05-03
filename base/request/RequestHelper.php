<?php

namespace base\request;
require_once 'base/request/RequestException.php';
use base\request\RequestException;
/**
 * 请求助手,用户解析url的，并且将对应的参数进行设置
 * @author prg
 * @copyright 2014-2015
 */
class RequestHelper
{
	/**
	 * 单例对象
	 * @var RequestHelper
	 */
	static private $instance;
	
	/**
	 * 不能被实例化
	 */
	private function __construct(){}
	
	/**
	 * 获取单例对象
	 * @return \base\RequestHelper
	 */
	static function instance(){
		if(!isset(self::$instance)||is_null(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 初始化请求，设定请求参数 和文件上传  只支持post 和get参数
	 * @param Request $req
	 */
	public function init(Request $req){
		$request_uri = $_SERVER['REQUEST_URI'];
		$req->setRequestUri($request_uri);
		if(strlen($request_uri)<=1){ //home page
			$req->setCurCmdStr('index');
			return ;
		}
		$cmdpattern = '/^\/([a-zA-Z0-9]+)/i';//第一个字段用于表示命令后面的都是参数
		$cmdRes= array(); 
		$res   = preg_match($cmdpattern, $request_uri,$cmdRes);
		if(!$res){
			$req->setExcetion(new RequestException("Sorry! We Can't Find The Page! Please Try Again"));//404 error
			return;
		}
		$req->setCurCmdStr($cmdRes[1]);
		if(isset($_SERVER['REQUEST_METHOD'])){
			$req->setReqMethod($_SERVER['REQUEST_METHOD']);
			//no cookie
			if(strtolower($_SERVER['REQUEST_METHOD'])=='get'){//get
				foreach ($_GET as $key=>$val){
					$req->setProperty($key, $val);
				}
			}else if(strtolower($_SERVER['REQUEST_METHOD'])=='post'){//post
				foreach ($_POST as $key=>$val){
					$req->setProperty($key, $val);
				}
			}
		}
		if(!empty($_FILES)){ //upload file
			foreach ($_FILES as $key=>$val){
				$req->setFile($val);
			}
		}
		return ;
	}
}
?>