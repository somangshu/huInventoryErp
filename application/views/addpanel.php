<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php echo $title ?>
	</title>	
</head>
<body>
	<form name="addpanelform" id="addpanelform" onsubmit="return addpanel()" method="post">
		<fieldset>
  		<h3>Panel Information</h3>
  		<p>
  		Panel parent: <input type="text" name="panelparent" id="panelparent">
    	<br />
    	<br />
    	Panel name: <input type="text" name="panelname" id="panelname">
    	<br />
    	<br />
    	Panel description: <input type="text" name="paneldesc" id="paneldesc">
    	<br />
    	<br />
    	Panel url: <input type="text" name="panelurl" id="panelurl">
    	<br />
    	<br />
    	Panel type: <input type="text" name="paneltype" id="paneltype">
    	<br />
    	<br />
    	Is Active: 
    	<br />
    	<input type="radio" name="active" value="display" checked> Display<br>
		<input type="radio" name="active" value="hidden"> Hidden<br>
  		</p>
  		
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="submit" onclick="addpanel();">
  		</fieldset>
	</form>
</body>
</html>