<?php

namespace base;

class BaseException extends \Exception
{
	/**
	 * (non-PHPdoc)
	 * @see Exception::__toString()
	 */
	function __toString(){
		return  $this->getMessage();
	}
}

?>