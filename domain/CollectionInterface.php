<?php

namespace domain;

interface CollectionInterface extends \Iterator {
	function add(\domain\DomainObject $object);
}

?>