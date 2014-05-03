<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>User Login</title>
</head>
<body>
<?php
	echo \base\response\ResponseRegisty::getResponse()->getFeedbackStr(); 
?>

<form action="/login" method="post">
	name:<input type="text" name="user" /><br/>
	Pw d:<input type="text" name="password" /> <br />
	<input type="submit" value="sub" />
</form>
</body>
</html>