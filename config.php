<?php
    //��������
    $con = mysql_connect("localhost:3306" , "root" , "") ;
    mysql_query("SET NAMES UTF8");
      //�������� �� ��������
      if (!$con)
      {    
          die('Could not connect: ' . mysql_error());      
	  }
	  
	  else
	  {  
	     //echo "����� �� !!!";
	  }
 
      //����� �� ������
      mysql_select_db("store", $con);
	 
?>