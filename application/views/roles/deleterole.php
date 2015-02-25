<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo $title;?>
	</title>	
</head>
<body>
	<form name="deleteroleform" id="deleteroleform" onsubmit="return deleterole()" method="post">
		<fieldset>
		<h3>Delete Role</h3>
		<p>
    	Roles:
    	<br /> 
    	<select name="role" id="role">	
  			<?php 
  				foreach($rolesArray as $row)
  					echo '<option value="'.$row['roleid'].'">'.$row['rolename']."</option>";
  			?>
		</select>
  		<br />
  		<br />
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="Delete Role" onclick="deleterole();">
  		
  		</fieldset>
	</form>
</body>
</html>