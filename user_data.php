<?php

  require('config.php');
  
  class Details
 {
    // get all products
    function getData($date_from,$distributor)
    {  
	   $sStr = "";
	   if($distributor !== null)  
	   {
	     $sStr = " WHERE pd.contractor_id = ".(int)$distributor;
	   }
       $SelectString  = "SELECT pd.product_id AS product_id ,
	   pd.product_name AS product_name ,
	   CASE WHEN pr.insert_date >= '" . $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' THEN pr.quantity ELSE 0 END AS quantity, 
	   CASE WHEN pr.insert_date >= '" . $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' THEN pr.distributor_price ELSE 0 END AS distributor_price,
	   CASE WHEN pr.insert_date >= '" . $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' THEN pr.selling_price ELSE 0 END AS selling_price ,
	   pr.insert_date AS insert_date ,
	   un.unit_name AS unit_name ,
	   cnt.contractor_name AS contractor_name
	   FROM products pd 
	   LEFT JOIN units un ON pd.unit_id = un.unit_id 
	   LEFT JOIN contractor cnt ON cnt.contractor_id = pd.contractor_id
	   LEFT JOIN prices pr ON pr.product_id = pd.product_id " 
	   . $sStr . " Order By product_name ASC";
	   $Result = mysql_query($SelectString);	
       if(false === $Result)
	   {
          echo mysql_error();
       }   
	   return  $Result;
	   //  WHERE pd.insert_date >= '" .  $this->strToSqlDate($date_from) ."' and pd.insert_date <= 'CURDATE()'
    }
	
	// get monitoring data
    function getMonitoringData($date_from)
    {  	   
       $SelectString  = "SELECT SUM( pr.distributor_price * pr.quantity ) AS subtotal,
	   SUM( pr.selling_price *  pr.quantity ) AS total,
	   SUM( pr.selling_price *  pr.quantity ) - SUM( pr.distributor_price * pr.quantity ) AS income
       FROM  `products` pd 
	   LEFT JOIN prices pr ON pr.product_id = pd.product_id 
	   WHERE pr.insert_date >= '". $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' ";
	   $Result = mysql_query($SelectString);	
       if(false === $Result)
	   {
          echo mysql_error();
       }   
	   return  $Result;
    }
	
	// get update data
	function getDataUpdate($pr_id,$date_from)
	{  	  
       $SelectString  = "SELECT pd.product_id AS product_id ,
	   pd.product_name AS product_name ,
	   CASE WHEN pr.insert_date >= '" . $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' THEN pr.quantity ELSE 0 END AS quantity, 
	   CASE WHEN pr.insert_date >= '" . $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' THEN pr.distributor_price ELSE 0 END AS distributor_price,
	   CASE WHEN pr.insert_date >= '" . $this->strToSqlDate($date_from) ."' and pr.insert_date <= 'CURDATE()' THEN pr.selling_price ELSE 0 END AS selling_price ,
	   pr.insert_date AS insert_date,
	   un.unit_id AS unit_id ,
	   cnt.contractor_id AS contractor_id,
	   un.unit_name AS unit_name ,
	   cnt.contractor_name AS contractor_name
	   FROM products pd 
	   LEFT JOIN units un ON pd.unit_id = un.unit_id 
	   LEFT JOIN contractor cnt ON cnt.contractor_id = pd.contractor_id 
       LEFT JOIN prices pr ON pr.product_id = pd.product_id 	  
	   WHERE pd.product_id = '$pr_id'" ;
	   $Result = mysql_query($SelectString);
	   if(false === $Result)
	   {
          echo mysql_error();
       }   
	   return  $Result;
	}
	
	//get units
    function getUnits()
    {  
       $SelectString  = "SELECT *  FROM `units` Order By `unit_name` Asc ";	  
       $Result        = mysql_query($SelectString);	
	   if (false === $Result)
	   {
          echo mysql_error();
       }	
	   return  $Result;
    }
	
    // get contractor
    function getDistributors()
   {  
       $SelectString  = "SELECT *  FROM `contractor` Order By `contractor_name` Asc ";	  
       $Result        = mysql_query($SelectString);	
	   if (false === $Result)
	   {
          echo mysql_error();
       }	
	   return  $Result;
   }
   
    // get contractor data
   function getContractorData($contractor_id)   
   {
      $SelectString  = "SELECT *  FROM `contractor` WHERE contractor_id = '$contractor_id'";	  
      $Result        = mysql_query($SelectString);	
	  if (false === $Result)
	  {
          echo mysql_error();
      }	
	   return  $Result;
   }
   
   // get user data
   function getUserData($data_id)
	{  	  
       $SelectString  = "SELECT * FROM user_data WHERE data_id = '$data_id'" ;
	   $Result = mysql_query($SelectString);
	   if(false === $Result)
	   {
          echo mysql_error();
       }   
	   return  $Result;
   }
   
   // selected options / units and contractors /
   function selectTag($name, $values, $selected = null, $id_name ,$unassigned = null)
   {
       $id_select    = $id_name ."_id";
       $name_select  = $id_name ."_name";
       $selectString = '<select id="'.$name.'" name="'.$name.'">'."\n";
	   $number = 0;
	   $sStr = "";
       while ($row = mysql_fetch_array($values))
	   {	
        if( $number == 0 && $unassigned !== null)
		{
		  $sStr = '<option value="-1"> <Неуказано> </option>';
		}
        else{$sStr = "";}		
		$optionString = $sStr.' <option value="'.$row[$id_select].'"';
		if ($row[$id_select] == $selected)
		{
		    $optionString .= 'selected';				
		}
		$optionString .= '>'.$row[$name_select].'</option>'."\n";
        $selectString .= $optionString;
	    $number++;
      }
      $selectString .= '</select>'."\n";
      return $selectString;
    }
	
    // update Product Prices
   function updateProductPrices()
	{  	  
       $SelectString  = "UPDATE products SET distributor_price = '0.00' ,selling_price = '0.00' " ;
	   $Result = mysql_query($SelectString);
	   if(false === $Result)
	   {
          echo mysql_error();
       }   
	   return  $Result;
   }
	
	// Date function for SQL
	function strToSqlDate($date)
	{
	  return  date('Y-m-d', strtotime($date));
	}
	
	// Date function for calendar format
	function strDateToString($date)
	{
	  return  date('d.m.Y', strtotime($date));
	}
	
  } 
?>
