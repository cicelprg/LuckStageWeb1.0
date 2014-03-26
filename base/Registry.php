<?php
namespace base;

/**
 * 	注册表类ע
 *   @author prg
 *   @copyright 2014 - 2015
 */
abstract class Registry {
	abstract protected function get($key);
	abstract protected function set($key,$val); 
}

?>