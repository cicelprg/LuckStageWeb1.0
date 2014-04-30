<?php

namespace mapper;

use domain\DomainObject;

require_once 'base/ApplicationRegistry.php';
use base\ApplicationRegistry;

require_once 'domain/DomainObject.php';

/**
 * Data Mapper
 * @author prg
 * @copyright 2014
 */
abstract class Mapper
{
	protected static $pdo; 
	
	/**
	 * 生成PDO对象
	 * @return NULL
	 */
	function __construct(){
		if(!isset(self::$pdo)){
			$dsnObject = ApplicationRegistry::getMysql();
			$dsn       = $dsnObject->getDrive().':dbname='.$dsnObject->getDB();
			$user      = $dsnObject->getUser();
			$pwd       = $dsnObject->getPassword();
			try{
				self::$pdo = new \PDO($dsn, $user, $pwd);
				self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);//set exception
			}catch (\PDOException $pe){
				echo $pe->getMessage();
			}
		}
	}
	
	/**
	 * 通过对象插入数据
	 * @param \DomainObject $domain
	 */
	function insert(\domain\DomainObject $domain){
		$this->doInsert($domain);
	}
	/**
	 * 创建对象
	 * @param Array $array
	 * @return DomainObject
	 */
	function createObject($array){
		$object = $this->doCreateDomainObject($array);
		return $object;
	}
	
	/**
	 * 插入操作
	 * @param \DomainObject $domain
	 */
	protected abstract function doInsert(\domain\DomainObject $domain);
	/**
	 * 将数组转换成对象
	 * @param array $array
	 */
	protected abstract function doCreateDomainObject(array $array);
}

?>