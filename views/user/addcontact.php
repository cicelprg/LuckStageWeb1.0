<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Add Contact</title>
</head>
<body>
<?php
echo \base\response\ResponseRegisty::getResponse()->getFeedbackStr();
?>
<form action="/addcontact" method="post">
	Tel :<input type="text" name="tel" />
	<input type="submit" value="sub" />
</form>
</body>
</html>