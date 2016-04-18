<html>
<?php
  require('config.php');
  require('user_data.php');
  
  $ObjDetails       =  new Details(); 
  $distributorNames =  $ObjDetails->getDistributors();
  $unitNames        =  $ObjDetails->getUnits();
  
  if ($_SERVER['REQUEST_METHOD'] != 'POST')
  {	
      $product_name = "";
      $quantity =  1;
      $unit =  1;
      $distributor_price =  0.00;
      $selling_price =   0.00;
      $selectedDistributor = null;	
	  $selectedUnit = null;
  }
  else
  {
     $selectedDistributor = isset($_POST['selected_distributor']) ? $_POST['selected_distributor']: '';
	 $selectedUnit = isset($_POST['selected_unit']) ? $_POST['selected_unit']: '';
  }
?>
<head>
   <title>Въвеждане на продукт</title>
</head>
<body >
<form  id="form" action="insert_form.php" method= "post">

<fieldset>
<legend>Продукт</legend>
<table>

<tr> <td style="border:none;"> <h5>Име на продукта</h5> </td>        <td style="border:none;"><input type="text" name="product_name" id="product_name" value="" size="40" required></td> </tr>
<tr> <td style="border:none;"> <h5>Количество</h5>      </td>        <td style="border:none;"> <input type="text" name="quantity" id="quantity" value="" size="40" required></td> </tr>
<tr> <td style="border:none;"> <h5>М.единица</h5>       </td>        <td style="border:none;"><?php echo $ObjDetails->selectTag('selected_unit',$unitNames ,$selectedUnit,'unit') ?> </td> </tr>
<tr> <td style="border:none;"> <h5>Доставна цена</h5>   </td>        <td style="border:none;"><input type="text" name="distributor_price" id="distributor_price" size="40" required> </td> </tr>
<tr> <td style="border:none;"> <h5>Продажна цена</h5>   </td>        <td style="border:none;"><input type="text" name="selling_price" id="selling_price" size="40" required> </td> </tr>
<tr> <td style="border:none;"> <h5>Дистрибутор</h5>     </td>        <td style="border:none;"><?php echo $ObjDetails->selectTag('selected_distributor',  $distributorNames, $selectedDistributor,'contractor') ?> </td> </tr>

<tr>  <td colspan="2" > <div style=" padding: 5px; text-align:center">
<input type="submit" class="button1" value="Въведете данните" />
</div> </td></tr>
</table>
</fieldset>
<?php 
		
 if(!empty($_POST))
    {	 
      $product_name        = $_POST['product_name'];
	  $quantity            = $_POST['quantity'];
	  $distributor_price   = str_replace(',','.',$_POST['distributor_price']);
	  $selling_price       = str_replace(',','.',$_POST['selling_price']);
	  $today               = (new \DateTime())->format('Y-m-d');
	  $selectedDistributor = isset($_POST['selected_distributor']) ? $_POST['selected_distributor']: '';
	  $selectedUnit        = isset($_POST['selected_unit']) ? $_POST['selected_unit']: '';
	}	
    $proverka1 = isset($_POST['product_name']) ? $_POST['product_name'] : false;
	if ($proverka1)
	{
       $productsSQL = "INSERT INTO products (product_name ,unit_id,contractor_id) VALUES ('$product_name' ,'$selectedUnit' ,'$selectedDistributor')";
       $result = mysql_query($productsSQL) or die(mysql_error());
	   
       $productsPrices = "INSERT INTO prices (product_id , quantity ,distributor_price ,selling_price ,insert_date )
	   VALUES ('".mysql_insert_id()."' , '$quantity', '$distributor_price' ,'$selling_price','$today' )";
       $resultPrices = mysql_query($productsPrices) or die(mysql_error());  	   
	   if ($result && $resultPrices) 
	   {
	     header("Location: index.php");	 
         die();
	   }
    }
?>
</form>
</body>
</html>