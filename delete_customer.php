<?php

 include('config.php');
 
 $id = $_POST['id'];
 $resultProducts = mysql_query("DELETE FROM contractor WHERE contractor_id = ".$id) or die('Грешка при изтриване на доставччика! ' . mysql_error());
 
 
?>