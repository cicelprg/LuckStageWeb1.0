<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Modify Contact</title>
</head>
<body>
<?php
$old    =  \base\response\ResponseRegisty::getResponse()->getDataFromArray('address_id');
$old_id =  \base\response\ResponseRegisty::getResponse()->getDataFromArray('old_id');
echo \base\response\ResponseRegisty::getResponse()->getFeedbackStr();
?>
<form action="/modify" method="post">
	Tel :<input type="text" name="tel" value="<?php if(isset($old)){echo $old->getTel();} ?> "/>
		 <input type="hidden" name="address_id" value="<?php if(isset($old_id)){echo $old_id;}?>" />
	<input type="submit" value="sub"/>
</form>
</body>
</html>