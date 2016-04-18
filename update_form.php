<html>
<?php
  require('config.php');
  require('user_data.php');
  
 
  $ObjDetails       =  new Details(); 
  $distributorNames =  $ObjDetails->getDistributors();
  $unitNames        =  $ObjDetails->getUnits();
 
  $product_id       =  isset($_GET['id']) ? (int)$_GET['id']: 0;
  
  // get user settings
  $resultUserData   =  $ObjDetails->getUserData('1');
  $user_date        = date("Y-m-d");
  if(mysql_num_rows($resultUserData) >= 1)
  {
    while($row = mysql_fetch_array($resultUserData))
    {	  
       
        $user_date              = $ObjDetails->strDateToString($row['user_date']);
      
    }
  }
  $resultProduct    =  $ObjDetails->getDataUpdate($product_id,$user_date);
  
  if(!empty($_POST))
  {	 
      $product_id         =  $_POST['product_id'];
      $product_name        = $_POST['product_name'];
	  $quantity            = $_POST['quantity'];
	  $distributor_price   = str_replace(',','.',$_POST['distributor_price']);
	  $selling_price       = str_replace(',','.',$_POST['selling_price']);
	  $today               = date("Y-m-d");
	  $selectedDistributor = isset($_POST['selected_distributor']) ? $_POST['selected_distributor']: '';
	  $selectedUnit        = isset($_POST['selected_unit']) ? $_POST['selected_unit']: '';
  }	
  
  if(mysql_num_rows($resultProduct) >= 1)
  {
    while($row = mysql_fetch_array($resultProduct))
	{	  
        $product_name        = $row['product_name'];
        $quantity            = $row['quantity'];
        $distributor_price   = $row['distributor_price'];
        $selling_price       = $row['selling_price'];
		$selectedDistributor = $row['contractor_id'];
	    $selectedUnit        = $row['unit_id'];
    }
  }
 
?>
<head>
   <title>Редакция на продукт</title>
</head>
<body >
<form  id="form" action="update_form.php" method= "post" >

<fieldset>
<legend>Данни за продукта:</legend>
<table>
<input type="hidden" name="product_id" value="<?=$product_id;?>">
<tr> <td style="border:none;"> <h5>Име на продукта</h5> </td>        <td style="border:none;"><input type="text" name="product_name" id="product_name" value="<?=$product_name?>" size="40" required></td> </tr>
<tr> <td style="border:none;"> <h5>Количество</h5>      </td>        <td style="border:none;"> <input type="text" name="quantity" id="quantity" value="<?=$quantity?>" size="40" required></td> </tr>
<tr> <td style="border:none;"> <h5>М.единица</h5>       </td>        <td style="border:none;"><?php echo $ObjDetails->selectTag('selected_unit',$unitNames ,$selectedUnit,'unit') ?> </td> </tr>
<tr> <td style="border:none;"> <h5>Доставна цена</h5>   </td>        <td style="border:none;"><input type="text" name="distributor_price" id="distributor_price"  value="<?=$distributor_price?>" size="40" required> </td> </tr>
<tr> <td style="border:none;"> <h5>Продажна цена</h5>   </td>        <td style="border:none;"><input type="text" name="selling_price" id="selling_price" value="<?=$selling_price?>" size="40" required> </td> </tr>
<tr> <td style="border:none;"> <h5>Дистрибутор</h5>     </td>        <td style="border:none;"><?php echo $ObjDetails->selectTag('selected_distributor',  $distributorNames, $selectedDistributor,'contractor') ?> </td> </tr>

<tr>  <td colspan="2" > <div style=" padding: 5px; text-align:center">
 <input type="submit" class="button1" value="Въведете данните" />
 <!--<input type="button" value="Въведете данните" onClick="SubmitForm();"/>	-->
</div> </td></tr>
</table>
</fieldset>
<?php
		
 
    $proverka1 = isset($_POST['product_id']) ? $_POST['product_id'] : false;
	if ($proverka1)
	{
       $productsSQL  = " UPDATE products SET product_name = '$product_name' ,
	   unit_id = '$selectedUnit' , contractor_id = '$selectedDistributor' WHERE product_id = '$product_id' ";
	   
	   $resultProducts = mysql_query($productsSQL) or die(mysql_error()); 
	   
	   $pricesSQL  = " UPDATE prices SET quantity = '$quantity', distributor_price = '$distributor_price' ,
	   selling_price = '$selling_price' ,insert_date = '$today'  WHERE product_id = '$product_id' ";
	   /*
       if(mysql_affected_rows() >= 1)
	   {
          echo "<p>($product_id) Record Updated<p>";
       }
	   else
	   {
          echo "<p>($product_id) Not Updated<p>";
       }
	    */
	   $resultPrices = mysql_query($pricesSQL) or die(mysql_error());  
	   if ($resultPrices &&  $resultProducts) 
	   {
	     header("Location:index.php");	 
         die();
		
		 
	   }
    }
?>
</form>
</body>


</html>