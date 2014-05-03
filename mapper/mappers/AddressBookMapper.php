<?php

namespace mapper\mappers;

require_once 'mapper/collections/AddressCollection.php';
use mapper\collections\AddressCollection;

require_once ('mapper/Mapper.php');
use mapper\Mapper;

require_once 'domain/domains/AddressBook.php';

class AddressBookMapper extends Mapper
{
	private static $findsByUserId = "select address_id,tel from addressbook where uid = ?";
	 
	function __construct(){
		parent::__construct();
	}
	
	protected function doInsert(\domain\DomainObject $domain){
		
	}
	
	protected function doCreateDomainObject(array $array){
		return new \domain\domains\AddressBook($array['tel'],@$array['uid'],@$array['address_id']);
	}
	
	function findByUser($user){
		if(!$user instanceof \domain\domains\User){
			throw new \Exception("$user not a object");
		}
		$stmt = self::$pdo->prepare(self::$findsByUserId);
		$id = $user->getID();
		$stmt->bindParam(1, $id);
		$stmt->execute();
		
		return $this->getSelfCollection($stmt->fetchAll(\PDO::FETCH_ASSOC));
	}
	
	protected function getSelfCollection(array $arr){
		return new AddressCollection($arr,$this);
	}
}

?>