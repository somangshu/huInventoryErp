<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo $title;
			  echo "hello";
		?>
	</title>	
</head>
<body>
	<form name="adduserform" id="adduserform" onsubmit="return adduser()" method="post">
		<fieldset>
		<h3>User Information</h3>
		<p>
    	User Name(Email-id): <input type="text" name="username" id="username"> 
    	<br />
    	<br />

    	Name: <input type="text" name="name" id="name">
    	<br />
    	<br />

    	Password: <input type="password" name="password" id="password">
    	<br />
    	<br />
    	
    	ROLES: 
    	<select name="role" id="role">	
  			<?php 
  				foreach($rolesArray as $row)
  					echo '<option value="'.$row['roleid'].'">'.$row['rolename']."</option>";
  			?>
		</select>
	<!--  	<br />
		<br />
		Panels:
		<br />
			<?php 
				foreach($panelsArray as $row)
					echo '<input type="checkbox" name="checklist[]" value="'.$row['panel_name'].'">'.$row['panel_name']."</checkbox><br />"
			?>
  		</p>
  		-->
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="submit" onclick="adduser();">
  		
  		</fieldset>
	</form>
</body>
</html>