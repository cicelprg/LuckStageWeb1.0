<?php

namespace controller;
/**
 * mysql 配置信息类
 * @author prg
 * @package controller
 */
class controllerMysql 
{
	/**
	 * host name
	 * @var string
	 */
	private $hostName;
	
	/**
	 * user name
	 * @var string
	 */
	private $userName;
	
	/**
	 * user password
	 * @var string
	 */
	private $userPwd;
	
	/**
	 * database name
	 * @var string
	 */
	private $dbName;
	
	/**
	 * database drive
	 * @var string
	 */
	private $drive;
	
	/**
	 * set host
	 * @param string $host
	 */
	function setHost($host="localhost"){
		$this->hostName = $host;
	}
	/**
	 * get host
	 * @return string
	 */
	function getHost(){
		return $this->hostName;
	}
	/**
	 * set user
	 * @param string $user
	 */
	function setUser($user='root'){
		$this->userName = $user;
	}
	
	/**
	 * get user name
	 * @return string
	 */
	function getUser(){
		return $this->userName;
	}
	
	/**
	 * set password
	 * @param unknown_type $pwd
	 */
	function setPassword($pwd=''){
		$this->userPwd = $pwd;
	}
	/**
	 * get password
	 * @return string
	 */
	function getPassword(){
		return $this->userPwd;
	}
	
	/**
	 * set database name
	 * @param string $dbname
	 */
	function setDB($dbname){
		$this->dbName = $dbname;
	}
	
	/**
	 * get database name
	 * @return string
	 */
	function getDB(){
		return $this->dbName;
	}
	
	/**
	 * set database drive
	 * @param string $drive
	 */
	function setDrive($drive = 'mysql'){
		$this->drive = $drive;
	}
	
	/**
	 * get database drive
	 * @return string
	 */
	function getDrive(){
		return $this->drive;
	}
}

?>