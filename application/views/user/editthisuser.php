<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php 
			echo $title;
		?>
	</title>	
</head>
<body>
	<form name="editthisuserform" id="editthisuserform" onsubmit="return updateuser()" method="post">
		<fieldset>
		<h3>User Information</h3>
		<p>
    	User ID: <input type="text" name="userid" id="userid" readonly value="<?php echo $allInformation[0]['user_id'];?>">
    	<br />
    	<br />
    	Name: <input type="text" name="name" id="name" value="<?php echo $username;?>">
    	<br />
    	<br />
    	
    	Active:
    	<br />
    	<input type="radio" name="active" id="active" value="yes"
    	<?php 
    		if($allInformation[0]['active'])
    			echo 'checked';
    	?>>Active</input>
    	<br />
    	<input type="radio" name="active" id="inactive" value="no"
    	<?php 
    		if(!$allInformation[0]['active'])
    			echo 'checked';
    	?>>Inactive</input>
    	<br />
    	<br />
    	
    	ROLES: 
    	<select name="role" id="role">	
  			<?php 
  				foreach($rolesArray as $row)
  				{
  					if($row['rolename'] == $allInformation[1]['rolename'])
  						echo '<option value="'.$row['rolename'].'" selected="selected">'.$row['rolename']."</option>";
  					else
  						echo '<option value="'.$row['rolename'].'">'.$row['rolename']."</option>";
  				}
  						
  			?>
		</select>
		<br />
		<br />
  		
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="Edit user" onclick="updateuser();">
  		
  		</fieldset>
	</form>
</body>
</html>