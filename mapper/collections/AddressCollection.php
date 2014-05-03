<?php
namespace mapper\collections;
require_once 'domain/interfaces/AddressCollection.php';
use domain\interfaces\AddressCollectionInterface;

require_once ('mapper/Collection.php');

use mapper\Collection;

class AddressCollection extends Collection implements AddressCollectionInterface 
{
	protected function targetClass(){
		return "\\domain\\domains\\AddressBook";
	}
}

?>