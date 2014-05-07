<?php
namespace command\contact;
require_once 'domain/factory/Helpfactory.php';
use domain\factory\Helpfactory;
use base\response\ResponseRegisty;
require_once ('command/Command.php');
use \command\Command;
require_once 'mapper/mappers/AddressBookMapper.php';
use \mapper\mappers\AddressBookMapper;

/**
 * 修改联系人信息命令
 * @author prg
 * @copyright 2014-2015
 */
class ModifyCommand extends command 
{
	function doExcute(\base\request\Request $request){
		$arr = array('address_id'=>$request->getProperty('address_id'),'tel'=>$request->getProperty('tel'));
		$response = ResponseRegisty::getResponse();
		if($arr['address_id']==''){
			$response->addFeedback('没有要修改的数据');
			return self::statuses();
		}else{
			$response->addData('old_id',$arr['address_id']);
			if(!isset($arr['tel'])||$arr['tel']==''){ //check data
				$response->addFeedback('信息没有填写完整');
				return self::statuses();
			}else {
				$addressMapper = Helpfactory::getMapper("\\mapper\\mappers\\AddressBookMapper");
				try{
					$addressMapper->updateById($addressMapper->createObject($arr));
				}catch(\mapper\MapperException $me){
					echo $me;
					return self::statuses();
				}
				return self::statuses('SYS_SUCCESS');
			}
		}
		return self::statuses();
	}
}

?>