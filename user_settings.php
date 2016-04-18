<html>
<?php

  require('config.php');
  require('user_data.php');
  
  $ObjDetails       = new Details();
  $resultUserData   =  $ObjDetails->getUserData('1');
  
  $contractor = 0;
  $unit = 0;
  
  if(mysql_num_rows($resultUserData) >= 1)
  {
    while($row = mysql_fetch_array($resultUserData))
	{	  
        $user_contractor        = ($row['user_contractor'] == 1)?  'checked': '';
        $user_unit              = ($row['user_unit'] == 1)? 'checked': '';
        $user_date              = $ObjDetails->strDateToString($row['user_date']);
      
    }
  }
  //$user_date              = (new \DateTime())->format('Y-m-d');
?>

<head>
   <title>Настройки</title>
</head>
<script type="text/javascript">
	$(function(){						
			$("#user_date").datepicker($.extend({}, $.datepicker.regional["bg"], {
				showWeek: false,
				changeMonth: true,
				changeYear: true
			}));
		});
</script>
<body >
<form  id="form" action="user_settings.php" method= "post">
<fieldset>
<legend>Настройки</legend>
<h4>Начална дата:</h4>
<input type="text" id="user_date" name="user_date"  size="10" value="<?=$user_date?>" required />
<h4>Покажи бутона " Въведи доставчик ":</h4>
<input type="checkbox" name="contractor" id="contractor" value="<?=$user_contractor?>"   <?=$user_contractor?> ></input>
<h4>Покажи бутона " Въведи м. единица ":</h4>
<input type="checkbox" name="unit" id="unit"  value="<?=$user_unit?>"  <?=$user_unit?>  ></input>

<div style=" padding: 10px; text-align:center">
   <input type="submit" class="button1" value="Въведете данните" />
</div>

</fieldset>
<?php

    if(!empty($_POST))
    {	 
      if(isset($_POST['contractor']))
	  {$contractor = 1;}
	  
	  if(isset($_POST['unit']))
	  {$unit = 1;}
    
	  $user_date              = $ObjDetails->strToSqlDate($_POST['user_date']);
	}
	
    $proverka1 = isset($_POST['user_date']) ? $_POST['user_date'] : false;
	if ($proverka1)
	{
       $userSQL = "UPDATE user_data SET user_date = '$user_date' , user_unit = '$unit' , user_contractor = '$contractor' ";
       $result = mysql_query($userSQL) or die(mysql_error()); 
	 
	   if ($result) 
	   {
	     header("Location: index.php");	 
         die();
	   }
    }
?>

</form>
</body>
</html>