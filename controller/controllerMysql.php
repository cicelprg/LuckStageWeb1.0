<?php

namespace controller;
/**
 * 缓存mysql 配置信息
 * @author prg
 */
class controllerMysql 
{
	private $hostName;
	private $userName;
	private $userPwd;
	private $dbName;
	
	function setHost($host="localhost")
	{
		$this->hostName = $host;
	}
	
	function getHost()
	{
		return $this->hostName;
	}
	
	function setUser($user='root')
	{
		$this->userName = $user;
	}
	
	function getUser()
	{
		return $this->userName;
	}
	
	function setPassword($pwd='')
	{
		$this->userPwd = $pwd;
	}
	
	function getPassword()
	{
		return $this->userPwd;
	}
	
	function setDB($dbname)
	{
		return $this->dbName = $dbname;
	}
	
	function getDB()
	{
		return $this->dbName;
	}
}

?>