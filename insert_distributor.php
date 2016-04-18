<html>
<?php
  require('config.php');
?>
<head>
   <title>Доставчик</title>
</head>
<body >
<form  id="form" action="insert_distributor.php" method= "post">

<fieldset>
<legend>Доставчик</legend>
<h4>Име:</h4>
<input type="text" name="contractor_name" id="contractor_name" value="" size="50" required>
<h4>Забележка:</h4>
<textarea name="note" rows="5" cols="50"></textarea>

<div style=" padding: 10px; text-align:center">
    <input type="submit" class="button1" value="Въведете данните" />
</div>

</fieldset>
<?php

 $contractor_name = "";
 $note =  "";
 
 if(!empty($_POST))
    {	 
      $contractor_name = $_POST['contractor_name'];
	  $note = $_POST['note'];
	}	
    $proverka1 = isset($_POST['contractor_name']) ? $_POST['contractor_name'] : false;
	if ($proverka1)
	{
       $userSQL = "INSERT INTO contractor (contractor_name , note) VALUES ('$contractor_name' , '$note')";
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