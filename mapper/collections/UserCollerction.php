<?php

namespace mapper\collections;
require_once ('domain/interfaces/UserCollection.php');
require_once ('mapper/Collection.php');

use domain\interfaces\UserCollectionInterface;
use mapper\Collection;

class UserCollerction extends Collection implements UserCollectionInterface{
	
	protected function targetClass(){
		return "\\domain\\domains\\User";
	}
}

?>