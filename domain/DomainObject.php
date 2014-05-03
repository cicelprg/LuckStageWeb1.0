<?php
namespace domain;
require_once 'domain/factory/Helpfactory.php';
use domain\factory\Helpfactory;

abstract class DomainObject{
	static function getCollection($type){
		return Helpfactory::getCollection($type);
	} 
	
	function collection(){
		return self::getCollection(get_class($this));
	}
}
?>