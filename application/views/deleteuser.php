<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo $title;?>
	</title>	
</head>
<body>
	<form name="deleteuserform" id="deleteuserform" onsubmit="return deleteuser()" method="post">
		<fieldset>
		<h3>User Information</h3>
		<p>
    	User Name(Email-id): <input type="text" name="username" id="username"> 
    	<br />
    	<br />
  		
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="Delete User" onclick="deleteuser();">
  		
  		</fieldset>
	</form>
</body>
</html>