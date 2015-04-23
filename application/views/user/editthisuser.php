<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php 
			echo $title;
		?>
	</title>	
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
	<form name="editthisuserform" id="editthisuserform" class="adduserform" onsubmit="return updateuser()" method="post">
		<fieldset>
		<h3><i class="mdi-content-content-paste"></i> Edit User Information</h3>
    <div><hr></div>
	
    <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="userid" id="userid" readonly value="<?php echo $allInformation[0]['user_id'];?>">
                  <div class="floating-label">User ID</div><span class="material-input"></span>
            </div>
            </div>
    <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="name" id="name" value="<?php echo $username;?>">
                  <div class="floating-label">Name</div><span class="material-input"></span>
            </div>
    </div>
  <div class="form-group">
              <div class="form-control-wrapper">
    	Active:
    
  
      <div class="radio radio-primary" style="margin-bottom: 10px;margin-top: 10px;">
    	<label style="margin-right: 20px;"><input type="radio" name="active" id="active" value="yes"
    	<?php 
    		if($allInformation[0]['active'])
    			echo 'checked';
    	?>><span class="circle"></span><span class="check"></span>Active</input></label>
    	
    	<label><input type="radio" name="active" id="inactive" value="no"
    	<?php 
    		if(!$allInformation[0]['active'])
    			echo 'checked';
    	?>><span class="circle"></span><span class="check"></span>Inactive</input></label>
    	</div>
     </div>
    </div>
      <div class="form-group">
              <div class="form-control-wrapper">
    	Roles:
    	<select class="form-control" name="role" id="role">	
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
  </div></div>
  		<div><hr></div>
      <div class="text-center">
  		<input type="button" id="sub" class="btn btn-primary" value="Edit user" onclick="updateuser();">
  	 </div>
  		</fieldset>
	</form>
  </div>
  </div>
  </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src = "public/js/default.js"></script>
</body>
</html>