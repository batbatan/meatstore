<?php

 include('config.php');
 
 $id = $_POST['id'];
 $resultProducts = mysql_query("DELETE FROM contractor WHERE contractor_id = ".$id) or die('������ ��� ��������� �� �����������! ' . mysql_error());
 
 
?>