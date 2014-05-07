<?php
echo "<h2>Here are ",base\session\SessionRegistry::getUser()->getUserName()," Contacts!</h2>";

$books = \base\response\ResponseRegisty::getResponse()->getDataFromArray('addressBooks');

echo '<table border=0 width="250px"><tr><td width="20%">ID</td> <td>Tel</td> <td>删除</td> <td>修改</td> </tr>';
foreach ($books as $book){
	echo '<tr>','<td>',$book->getID(),'</td>','<td>',$book->getTel(),'</td><td><a href="/delete?address_id=',$book->getID(),'">删除</a></td><td><a href="/modify?address_id=',$book->getID(),'">修改</a></td></tr>';
}

echo '</table><br/>';
echo '<a href="/addcontact" >添加联系人</a> &nbsp;<a href="lngout">注销</a>'; 
?>
