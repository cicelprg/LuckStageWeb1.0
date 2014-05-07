<?php
namespace mapper\mappers;
require_once 'mapper/MapperException.php';
require_once 'mapper/collections/AddressCollection.php';
use mapper\collections\AddressCollection;
require_once ('mapper/Mapper.php');
use mapper\Mapper;
require_once 'domain/domains/AddressBook.php';

/**
 * addressBookMappre 数据映射器
 * @author prg
 * @copyright 2014-2015
 */
class AddressBookMapper extends Mapper
{
	/**
	 * sql 根据用户id查找联系人
	 * @var string
	 */
	private static $findsByUserId = "select address_id,tel from addressbook where uid = ?";
	
	/**
	 * 插入一个对象
	 * @var string
	 */
	private static $insert        = "insert into addressbook(uid,tel) values(?,?)";
	
	/**
	 * 根据id删除一条记录
	 * @var string
	 */
	private static $deleteById    = "delete from addressbook where address_id=?";
	
	/**
	 * 根据ID查找
	 * @var string
	 */
	private static $findById      = "select address_id,uid,tel from addressbook where address_id=?";
	
	/**
	 * 根据Id 更新
	 * @var string
	 */
	private static $updateById    = "update addressbook set tel=? where address_id =?";
	
	/**
	 * __construct
	 */
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \mapper\Mapper::doInsert()
	 */
	protected function doInsert(\domain\DomainObject $domain){
		if(!$domain instanceof \domain\domains\AddressBook){
			throw new \mapper\MapperException($domain .'not instance AddressBook');
			return false;
		}else{
			try{
				$stmt = self::$pdo->prepare(self::$insert);
				if(!$stmt->execute(array($domain->getUserID(),$domain->getTel()))){
					throw new \mapper\MapperException($domain.'not insert into database in');
					return false;
				}
			}catch (\PDOException $pe){
				echo $pe;
				throw new \mapper\MapperException('PDO Error Insert '.__CLASS__);
				return false;	
			}
		}
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \mapper\Mapper::doCreateDomainObject()
	 */
	protected function doCreateDomainObject(array $array){
		return new \domain\domains\AddressBook(@$array['tel'],@$array['uid'],@$array['address_id']);
	}
	
	/**
	 * 查找用户的联系人
	 * @param Object $user
	 * @throws \Exception
	 * @return \mapper\collections\AddressCollection
	 */
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
	
	/**
	 * (non-PHPdoc)
	 * @see \mapper\Mapper::getSelfCollection()
	 */
	protected function getSelfCollection(array $arr){
		return new AddressCollection($arr,$this);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \mapper\Mapper::doDelete()
	 */
	protected function doDelete(\domain\DomainObject $domain){
		try {
			$stmt = self::$pdo->prepare(self::$deleteById);
			if(!$stmt->execute(array($domain->getID()))){
				throw new \mapper\MapperException('要删除的内容不存在');
				return false;
			}
		}catch(\PDOException $pe){
			throw new \mapper\MapperException('要删除的内容不存在');
			return false;
		}
		return true;
	}
	
	/**
	 * 根据联系人id更新
	 * @param string $addressbook
	 * @throws \mapper\MapperException
	 * @return boolean
	 */
	public function updateById($addressbook){
		if(!$addressbook instanceof \domain\domains\AddressBook){
			throw new \mapper\MapperException($addressbook.' not instance of AddressBook');
			return false;
		}else{
			try{
				$stmt = self::$pdo->prepare(self::$updateById);
				if(!$stmt->execute(array($addressbook->getTel(),$addressbook->getID()))){
					throw new \mapper\MapperException("update Error".__CLASS__);
					return false;
				}
			}catch(\PDOException $pe){
				throw new \mapper\MapperException("PDO Error".__CLASS__);
				return false;
			}
		}
		return true;
	}
}

?>