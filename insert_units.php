<html>
<?php
  require('config.php');
?>
<head>
   <title>Мерна единица</title>
</head>
<body >
<form  id="form" action="insert_units.php" method= "post">

<fieldset>
<legend>Мерна единица</legend>
<h4>Наименование:</h4>
<input type="text" name="unit" id="unit" value="" size="50" required>
<h4>Забележка:</h4>
<textarea name="note" rows="5" cols="50"></textarea>

<div style=" padding: 10px; text-align:center">
   <input type="submit" class="button1" value="Въведете данните" />
</div>

</fieldset>
<?php

 $unit = "";
 $note =  "";
 if(!empty($_POST))
    {	 
      $unit = $_POST['unit'];
	  $note = $_POST['note'];
	}	
    $proverka1 = isset($_POST['unit']) ? $_POST['unit'] : false;
	if ($proverka1)
	{
       $userSQL = "INSERT INTO units (unit_name , note) VALUES ('$unit' , '$note')";
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