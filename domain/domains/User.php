<?php

namespace domain\domains;

require_once ('domain/DomainObject.php');

use domain\DomainObject;

class User extends DomainObject 
{
	private $userName;
	private $userID;
	private $addressBooks;
	private $password;
	
	function __construct($id=null,$name=NULL,$password=null){
		$this->userID   = $id;
		$this->userName = $name;
		$this->password = $password;
	}
	
	function getUserName(){
		return $this->userName;
	}
	
	function setUserName($name = null){
		$this->userName = $name;
	}
	
	function setID($id=null){
		$this->userID = $id;
	}
	function getID(){
		return $this->userID;
	}
	
	function setPassword($pwd = null){
		$this->password = $pwd;
	}
	
	function getPassword(){
		return $this->password;
	}
	
}

?>