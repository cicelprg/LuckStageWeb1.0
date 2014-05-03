<?php

namespace base\response;

require_once ('base/Registry.php');

use base\Registry;

class ResponseRegisty extends Registry
{
	
	private static $instance;
	
	private $values = array();
	
	private function __construct(){}
	
	protected  function get($key){
		if(isset($this->values[$key]))
		{
			return $this->values[$key];
		}
		return null;
	}
	
	protected function set($key, $val){
		$this->values[$key] = $val;
	}
	
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	static function getResponse(){
		return self::instance()->get('response');
	}
	
	static function setResponse($response){
		self::instance()->set('response', $response);
	}
	
}

?>