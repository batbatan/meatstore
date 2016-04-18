<?php session_start(); ?>
<html>
<link rel="shortcut icon" href="images/meat-icon.png" type="image/x-icon"/>
<?php

  require('config.php');
  require('user_data.php');
  
  // get Object UserDetails
  $ObjDetails       = new Details(); 
  
  // get Contractor
  $distributorNames = $ObjDetails->getDistributors();
  $filter           = false;
  
  //$startMonth       = date('Y-m-d', strtotime(date('Y-m-1'))); // start date
  //$now              = (new \DateTime())->format('Y-m-d');
  
  // Dates by default
  $date_from        = (new \DateTime())->format('d.m.y');
  $user_date        = (new \DateTime())->format('d.m.y');
  
  $user_contractor  = 0;
  $user_unit        = 0;
  
  // get user settings
  $resultUserData   =  $ObjDetails->getUserData('1');

  if(mysql_num_rows($resultUserData) >= 1)
  {
    while($row = mysql_fetch_array($resultUserData))
	{	  
        $user_contractor        = ($row['user_contractor'] == 1)?  1: 0;
        $user_unit              = ($row['user_unit'] == 1)? 1: 0;
        $user_date              = $ObjDetails->strDateToString($row['user_date']);
      
    }
  }
  
  
  if ($_SERVER['REQUEST_METHOD'] != 'POST')
  {	
	 $selectedDistributor = null;	
     $date_from           = $ObjDetails->strDateToString($user_date);
    // $date_to             = $now;		
  }
  else
  {
     $selectedDistributor = isset($_POST['selected_distributor']) ? $_POST['selected_distributor']: '';
	 $filter              = isset($_POST['filter']);
	 $date_from           = $ObjDetails->strDateToString($_POST['datepicker_from']);
    // $date_to             = (string) $_POST['datepicker_to'];
  }
  
  // New Added For Keep The Filter
  if (!$filter)
  {
     $selectedDistributor = !empty( $_SESSION['selectedDistributor'])? $_SESSION['selectedDistributor'] : null;
  }
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  // get monitoring data 
  $monitoring       = $ObjDetails->getMonitoringData($date_from);
  $row_monitoring   = mysql_fetch_array($monitoring);
  //echo count($row_monitoring['income']);
  
?>
<head>
   <title>Магазин за месо</title>
</head>
<body >
 <fieldset style="height:100%;">
 <legend><strong><label>Меню</label></strong></legend>	
<script type="text/javascript" src="javascript/common.js"></script>
<script type="text/javascript" src="javascript/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="javascript/jquery.ui.datepicker-bg.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript">
	$(function(){				
			$("#datepicker_from").datepicker($.extend({}, $.datepicker.regional["bg"], {
				showWeek: false,
				changeMonth: true,
				changeYear: true
			}));
			$("#datepicker_to").datepicker($.extend({}, $.datepicker.regional["bg"], {
				showWeek: false,
				changeMonth: true,
				changeYear: true
			}));
		});
</script>
<div class="wrapper" > 

   <form action="index.php" method="post">
    <table>
	    <?php if ($user_contractor == 1) { ?>
    	    <th><button type="button" class="button2" onclick='insToSql("insert_distributor.php","550","Въвеждане на доставчик")' >Въведи доставчик</button></th>
	    <?php } ?>
		<?php if ($user_unit == 1) { ?>
		   <th><button type="button" class="button2" onclick='insToSql("insert_units.php","550","Въвеждане на мерна единица")'>Въведи м.единица</button></th>
	    <?php } ?>
		 
    	<th><button type="button" class="button2" onclick='insToSql("insert_form.php","650","Въвеждане на продукт")'>Въведи продукт</button>	</th> 
		
		<th>
		<?php echo $ObjDetails->selectTag('selected_distributor', $distributorNames, $selectedDistributor ,'contractor','unassigned') ?>	
	    <?php  if  (isset($_POST['selected_distributor']))  { ?>		
		 <?php  if  ($_POST['selected_distributor'] !== '-1' && $_POST['selected_distributor'] !== '' ) { ?>
		   <a style= 'margin-left:15px;' href='' onClick='return editCustomer("<?php echo $selectedDistributor; ?>")' ><img src='images/edit.png'/></a>
	       <a href='' onClick='return confirmMessageContractor("<?php echo $selectedDistributor; ?>")' ><img src='images/delete.png'/></a>
		   <?php } ?> 
		 <?php } ?>
		</th>
	
		<th><input type="text" id="datepicker_from" name="datepicker_from" value= "<?php echo $date_from ; ?>" /></th>
		<!--<th><input type="text" id="datepicker_to"  name="datepicker_to" value= "<?php echo $date_to; ?>" /></th>-->
		<th><input type="submit" class="button2" name="filter"  id="filter" value="Филтър" /></th>
		<!--<th><button type="button" class="button2" onclick='refresh()'>Изчисти филтъра</button>	</th>-->
		<th><button type="button" class="button2" onclick='insToSql("user_settings.php","550","Настройки")' >Настройки</button></th>
		<th><strong><label style="margin-left:5px;">Печалба:</label></strong></th>
		<th><strong><label style="margin-left:5px;"> <?php echo (count($row_monitoring['income']) > 0 )? number_format(round($row_monitoring['income'],2),2) : "0.00";?></label></strong></th>
		
	</table>

</div>

<div style="margin-top:25px;">  
   <form action="index.php" method="post" enctype="multipart/form-data" id="form" > 
	  <fieldset >
        <legend><strong><label>Продукти</label></strong></legend>		
        <table class="form"  border="1" style="text-align:center;"> 
		   <tr>
		   	<th><label><img src='images/edit.png' alt='edit' title='Редакция'/></label></th>
			<th><label><img src='images/delete.png'alt='delete' title='Изтриване'/></label></th>
            <th><label>Номер</label></th>
            <th><label>Продукт</label></th>
			<th><label>Доставчик</label></th>
			<th><label>Количество</label></th>
			<th><label>Мерна единица</label></th>                                                                         
			<th><label>Дата на въвеждане</label></th>
			<th><label>Ед.доставна цена</label></th>
	        <th><label>Ед.продажна цена</label></th>	
            <th><label>Ед.печалба</label></th>			
			<th><label>Общо доставна цена</label></th>
			<th><label>Общо продажна цена</label></th>
			<th><label>Обща печалба</label></th>
		
          </tr>		  
		  <?php                         
		    
		    if ($filter && $selectedDistributor == -1)
			{
		      $selectedDistributor = null;
			}
			
			// New Added For Keep The Filter
			if ($filter && $selectedDistributor !== -1)
			{
		       $_SESSION['selectedDistributor'] = $selectedDistributor;
			   $_SESSION['datepicker_from'] = $date_from;
			}
			
			if (! empty($_SESSION['selectedDistributor']))
			{
			  $selectedDistributor = $_SESSION['selectedDistributor'];
		    }
			
			if (! empty($_SESSION['datepicker_from']))
			{
			  $date_from = $_SESSION['datepicker_from'];
		    }
			////////////////////////////////////////////////////////////
			
			//else
			//{
			//   
			//}
			
			$query = $ObjDetails->getData($date_from,$selectedDistributor);
		    $number                = 1;
			$distributor_price     = 0;
			$selling_price         = 0;
			$income                = 0;
			$all_distributor_price = 0;
			$all_selling_price     = 0;
			$all_income            = 0;
			
		    while($row = mysql_fetch_array($query))
           {	
		   
		     $distributor_price     += round($row['distributor_price'],2);
			 $selling_price         += round($row['selling_price'],2);
			 $income                += round($row['selling_price'] - $row['distributor_price'],2);
			 $all_distributor_price += round($row['distributor_price'] * $row['quantity'],2);
			 $all_selling_price     += round($row['selling_price'] * $row['quantity'],2);
			 $all_income            += round(round($row['selling_price'] - $row['distributor_price'],2) * $row['quantity'],2);
			 $product_id            = $row['product_id'];
			 
		     echo "<tr>";
			 echo "<td><a href='' onClick='return editProdukt(\"$product_id\")' ><img src='images/edit.png'/></a></td>";
			 echo "<td><a href='' onClick='return confirmMessage(\"$product_id\")' ><img src='images/delete.png'/></a></td>";
             echo "<td>" .$number."</td>";
			 echo "<td >".$row['product_name']. "</td>";
			 echo "<td >".$row['contractor_name']. "</td>";
			 echo "<td >".$row['quantity']. "</td>";
			 echo "<td >".$row['unit_name']. "</td>";
			 echo "<td >". $ObjDetails->strDateToString($row['insert_date']). "</td>";
			
			 echo "<td >".round($row['distributor_price'],2). "</td>";
			 echo "<td >".round($row['selling_price'],2). "</td>";	
			 
             echo "<td >".round($row['selling_price'] - $row['distributor_price'],2). "</td>"; //Печалба
			 
			 echo "<td >".round($row['distributor_price'] * $row['quantity'],2). "</td>";
			 echo "<td >".round($row['selling_price'] * $row['quantity'],2). "</td>";
			 
			 echo "<td >".round(round( $row['selling_price'] - $row['distributor_price'],2) * $row['quantity'],2). "</td>"; // Обща Печалба
			
			 echo "</tr>";
			 $number ++;
            }	
			
            if ($number > 1)
			{			
			  echo "<tr>";
              echo "<td colspan='8' style=\"text-align:right;\" >"."<label>Всичко: </label>"."</td>";			
			  echo "<td ><label>".round($distributor_price,2). "</label></td>";
			  echo "<td ><label>".round($selling_price,2). "</label></td>";
              echo "<td ><label>".round($income,2). "</label></td>";			  
			  echo "<td ><label>".round($all_distributor_price,2). "</label></td>";
			  echo "<td ><label>".round($all_selling_price,2). "</label></td>";
			  echo "<td ><label>".round($all_income,2). "</label></td>";
			  echo "</tr>";
			}
			
		  ?>
        </table>
	   </fieldset>
   </form>
</div>

</fieldset>
</body>
</html>
