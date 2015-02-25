<?php
	if(isset($_POST['username']) === true && empty($_POST['username']) === false)
	{
		$query = mysql_query("SELECT password FROM users WHERE users.emailid = \"".trim($_POST['username'])."\"");
		echo (mysql_num_rows($query) !== 0) ? mysql_result($query, 0, 'password') : "User not found"; 
	}
?>