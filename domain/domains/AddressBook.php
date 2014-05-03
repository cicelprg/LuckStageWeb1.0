<?php

namespace domain\domains;

require_once ('domain/DomainObject.php');

use domain\DomainObject;

class AddressBook extends DomainObject
{
	private $tel;
	private $userID;
	private $ID;
	
	function __construct($tel=null,$userID = null,$ID = null){
		$this->tel    = $tel;
		$this->userID = $userID;
		$this->ID     = $ID;
	}
	
	function setID($id=null){
		$this->ID = $id;
	}
	
	function getID(){
		return $this->ID;
	}
	
	function setTel($tel){
		$this->tel = $tel;
	}
	
	function getTel(){
		return $this->tel;
	}
	
	function setUserID($uid){
		$this->userID = $uid;
	}
	
	function getUserID(){
		return $this->userID;
	}
}

?>