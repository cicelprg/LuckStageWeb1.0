<?php

namespace domain\factory;

class Helpfactory{
	static function getCollection($collection,$mapper=null,$raw=null){
		if(class_exists($collection)){
			return new $collection($raw,$mapper);
		}
		return null;
	}
	
	static function getFinder($finder){
		if(class_exists($finder)){
		}
	}
	
	static function getMapper($mapper){
		if(class_exists($mapper)){
			return new $mapper();
		}else{
			return null;
		}
	}
}
?>