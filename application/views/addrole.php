<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php echo $title ?>
	</title>	
</head>
<body>
	<form name="addroleform" id="addroleform" onsubmit="return addrole()" method="post">
		<fieldset>
  		<h3>Role Information</h3>
  		<p>
  		<br />
    	Role name: <input type="text" name="rolename" id="rolename">
    	<br />
    	<br />
    	Role description: <input type="text" name="roledesc" id="roledesc">
    	<br />
    	<br />
    	Is Active: 
    	</br>
    	<input type="radio" name="active" value="active" checked> Active<br>
		<input type="radio" name="active" value="inactive"> Inactive<br>
  		</p>
  		
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="submit" onclick="addrole();">
  		
  		</fieldset>
	</form>
</body>
</html>