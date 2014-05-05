<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php
	echo \base\response\ResponseRegisty::getResponse()->getFeedbackStr(); 
?>
<form action="/regist" method="post">
	Name:<input type="text" name="user" /><br/>
	Pw d:<input type="text" name="password" /> <br />
	RPwd:<input type="text" name="repassword" /> <br />
	<input type="submit" value="sub" /> <input type="reset" value="rest">
</form>
</body>
</html>