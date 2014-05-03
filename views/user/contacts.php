<?php

echo "<h2>Here are ",base\session\SessionRegistry::getUser()->getUserName()," Contacts!</h2>";

$books = \base\response\ResponseRegisty::getResponse()->getDataFromArray('addressBooks');

echo '<table border=0 width="250px"><tr><td width="20%">ID</td> <td>Tel</td> </tr>';
foreach ($books as $book){
	echo '<tr>','<td>',$book->getID(),'</td>','<td>',$book->getTel(),'</td>','</tr>';
}

?>