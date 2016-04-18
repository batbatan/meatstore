<?php
    //конекция
    $con = mysql_connect("localhost:3306" , "root" , "") ;
    mysql_query("SET NAMES UTF8");
      //Проверка за конекция
      if (!$con)
      {    
          die('Could not connect: ' . mysql_error());      
	  }
	  
	  else
	  {  
	     //echo "Върза се !!!";
	  }
 
      //името на базата
      mysql_select_db("store", $con);
	 
?>