<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>
		<?php echo $title ?>
	</title>	
</head>
<body>
	<form name="loginform" id="loginform" onsubmit="return validateLogin()" method="post">
		<fieldset>
		<p>
    	User Name: <input type="text" name="username" id="username"> 
    	<br />
    	<br />
    	Password: <input type="password" name="password" id="password">
  		</p>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		<input type="button" id="sub" value="submit" onclick="validateLogin();">
  		</fieldset>
	</form>
</body>
</html>