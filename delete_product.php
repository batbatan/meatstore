<?php

 include('config.php');
 
 $id = $_POST['id'];
 $resultProducts = mysql_query("DELETE FROM products WHERE product_id = ".$id) or die('Грешка при изтриване на продукта! ' . mysql_error());
 $resultPrices   = mysql_query("DELETE FROM prices WHERE product_id = ".$id) or die('Грешка при изтриване на цените на продукта! ' . mysql_error());
 
?>