<?php

namespace domain\domains;

require_once ('domain/DomainObject.php');

use domain\DomainObject;

class User extends DomainObject 
{
	private $userName;
	private $userID;
	private $password;
	
	/**
	 * addressBook收集器
	 * @var \mapper\collections\AddressCollection
	 */
	private $addressBook;
	
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
	
	function addAddressBook(AddressBook $book){
		$this->getAddressBook()->add($book);
	}
	
	function getAddressBook(){
		if(!isset($this->addressBook)){
			$this->addressBook = self::getCollection("\\mapper\\collections\\AddressCollection");
		}
		if(is_null($this->addressBook)){
			throw new \Exception("get AddressBookCollection failed");
		}
		return $this->addressBook;
	}
	
	function setAddressBook(\mapper\collections\AddressCollection $address){
		$this->addressBook = $address;
	}
}

?>