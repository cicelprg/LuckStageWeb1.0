<?php

namespace command;
require_once ('command/Command.php');
use base\Request;
use command\Command;

/**
 * 命令不正确404 错误页面
 * @author prg
 */
class ErrorCommand extends Command 
{
	function doExcute(Request $request){
	}
}
?>