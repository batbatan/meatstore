<?php

 include('config.php');
 
 $id = $_POST['id'];
 $resultProducts = mysql_query("DELETE FROM products WHERE product_id = ".$id) or die('������ ��� ��������� �� ��������! ' . mysql_error());
 $resultPrices   = mysql_query("DELETE FROM prices WHERE product_id = ".$id) or die('������ ��� ��������� �� ������ �� ��������! ' . mysql_error());
 
?>