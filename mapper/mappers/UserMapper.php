<?php

namespace mapper\mappers;

require_once 'mapper/collections/UserCollerction.php';
use mapper\collections\UserCollerction;

require_once ('mapper/Mapper.php');

use mapper\Mapper;

require_once 'domain/domains/User.php';

class UserMapper extends Mapper
{
	private static $findPwdByName = "select user_id,uname,upwd from users where uname=?";
	private static $findById      = "select user_id,uname from user where user_id = ?";
	private static $updateById    = "update users set uname = ? ,upwd=? where user_id = ?";
	private static $insert        = "insert into users(uname,upwd) values(?,?)";
	private static $findIdByName  = "select user_id from users where uname=?";
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * 插入数据，更新库
	 * @see \mapper\Mapper::doInsert()
	 * @param \domain\DomainObject
	 */
	protected function doInsert(\domain\DomainObject $domain){
		$insertStmt = self::$pdo->prepare(self::$insert);
		$values     = array($domain->getUserName(),$domain->getPassword());
		try{
			if(!$insertStmt->execute($values)){
				throw new \Exception('insert user error!');		
			}else{
				$domain->setID(self::$pdo->lastInsertId());
			}
		}catch (\Exception $e){
			echo $e->getMessage();
			exit;
		}
	}
	 
	 /**
	  * 生成user对象
	  * @see \mapper\Mapper::doCreateDomainObject()
	  * @return \domain\domains\User
	  */
	protected function doCreateDomainObject(array $array){
		$object = new \domain\domains\User(@$array['user_id'],@$array['uname'],@$array['upwd']);
		return $object;
	}
	
	/**
	 * 检查用户名与密码是否匹配
	 * @param array $arr
	 * @return boolean|mixed
	 */
	 function checkUser(array $arr){
		$stmt = self::$pdo->prepare(self::$findPwdByName);
		$stmt->bindParam(1, $arr['uname'],\PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if(!isset($row)||empty($row)){
			return false;
		}else if($row['upwd']!=$arr['upwd']){
			return false;
		}
		return $row;
	}
	
	/**
	 * 通过用户名查找id
	 * @param string $name
	 * @return mixed|NULL
	 */
	function findIdByName($name){
		$stmt = self::$pdo->prepare(self::$findIdByName);
		$stmt->bindParam(1, $name);
		$stmt->execute();
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if(isset($row)&&!empty($row)){
			return $row['user_id'];
		}
		return null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \mapper\Mapper::getSelfCollection()
	 */
	protected function  getSelfCollection(array $arr){
		return new UserCollerction($arr,$this);
	}
	
	protected function doDelete(\domain\DomainObject $domain){
		
	}
}

?>