<html>
<?php

  require('config.php');
  require('user_data.php');
 
  $ObjDetails      =  new Details(); 
  $contractor_id   =  isset($_GET['id']) ? (int)$_GET['id']: 0;
  $result          =  $ObjDetails->getContractorData($contractor_id);
  
  if(!empty($_POST)) 
  {	 
    $contractor_id         =  $_POST['contractor_id'];
    $contractor_name =  isset($_POST['contractor_name']) ? $_POST['contractor_name'] : '';
	$note =  isset($_POST['note']) ? $_POST['note'] : '';
  }
  
  if(mysql_num_rows($result) >= 1)
  {
    while($row = mysql_fetch_array($result))
	{	  
        $contractor_name        = $row['contractor_name'];  
        $note                   = $row['note'];  		
    }
  }
?>
<head>
   <title>Доставчик</title>
</head>
<body >
<form  id="form" action="update_distributor.php" method= "post">

<fieldset>
<legend>Доставчик</legend>
<input type="hidden" name="contractor_id" value="<?=$contractor_id;?>">
<h4>Име:</h4>
<input type="text" name="contractor_name" id="contractor_name"  value="<?=$contractor_name?>" size="50" required>
<h4>Забележка:</h4>
<textarea name="note" rows="5" cols="50"><?=$note?></textarea>

<div style=" padding: 10px; text-align:center">
    <input type="submit" class="button1" value="Въведете данните" />
</div>

</fieldset>
<?php

	$proverka1 = isset($_POST['contractor_name']) ? $_POST['contractor_name'] : false;
	$proverka2 = isset($_POST['contractor_id']) ? $_POST['contractor_id'] : false;
	
	if ($proverka2)
	{
       $userSQL = " UPDATE contractor SET contractor_name = '$contractor_name',  note = '$note' WHERE contractor_id = '$contractor_id' ";
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