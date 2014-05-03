<?php
namespace mapper;
require_once 'mapper/Mapper.php';
require_once 'domain/DomainObject.php';

/**
 * 处理数据库放回的多行数据
 * @author prg
 * @copyright 2014-2015
 */
abstract class Collection implements \Iterator
{
	/**
	 * @var Object Mapper
	 */
	protected $mapper;
	/**
	 * tatal raw
	 * @var int 
	 */
	protected $total = 0;
	/**
	 * row array
	 * @var array
	 */
	protected $raw = array();
	
	/**
	 * raw pointer
	 * @var int
	 */
	private $pointer = 0;
	
	/**
	 * object array
	 * @var array
	 */
	private $objects = array();
	
	/**
	 * init raw and mapper
	 * @param array $raw
	 * @param \mapper\Mapper $mapper
	 */
	function __construct(array $raw=null,\mapper\Mapper $mapper=null){
		if(!is_null($raw)&&!is_null($mapper)){
			$this->raw   = $raw;
			$this->total = count($raw);
		}
		$this->mapper = $mapper;
	}
	
	/**
	 * add a DomainObject to objects
	 * @param \domain\DomainObject $object
	 * @throws \Exception
	 */
	function add(\domain\DomainObject $object){
		$class = $this->targetClass();
		if(!$object instanceof $class){
			throw new \Exception("$object not extends $class");
		}
		$this->notifyAccess();
		$this->objects[$this->total++] = $object;
	}
	
	/**
	 * delay load the object
	 */
	protected function notifyAccess(){
		
	}
	
	/**
	 * get a row Object
	 * @param unknown_type $num
	 * @return NULL|multitype:
	 */
	private function getRaw($num){
		$this->notifyAccess();
		if($num>=$this->total || $num<0){
			return null;
		}
		if(isset($this->objects[$num])){
			return $this->objects[$num];
		}
		if(isset($this->raw[$num])){
			$this->objects[$num] = $this->mapper->createObject($this->raw[$num]);
			return $this->objects[$num];
		}
		
		return null;
	} 
	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::rewind()
	 */
	function rewind(){
		$this->pointer = 0;
	}
	
	/**
	 * get the current item
	 * @see Iterator::current()
	 */
	function current(){
		return $this->getRaw($this->pointer);
	}
	
	/**
	 * get the current pointer
	 * @see Iterator::key()
	 */
	function key(){
		return $this->pointer;
	}
	
	/**
	 * check the current item is valid
	 * @see Iterator::valid()
	 */
	function valid(){
		return (!is_null($this->current()));
	}
	
	/**
	 * get the current item and the pointer++
	 * @see Iterator::next()
	 */
	function next(){
		$row = $this->getRaw($this->pointer);
		if(!is_null($row)){
			$this->pointer++;
		}
		return $row;
	}
	
	/**
	 * set mapper
	 * @param \mapper\Mapper $mapper
	 */
	function setMapper(\mapper\Mapper $mapper){
		$this->mapper = $mapper;
	}
	
	/**
	 * get Mapper
	 * @return object
	 */
	function getMapper(){
		return $this->mapper;
	}
	
	/**
	 * get the target class name
	 */
	protected abstract function targetClass();
}

?>