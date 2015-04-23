<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php 
			$i = 0;
			echo $title;
		?>
	</title>	
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
	<form name="editroleform" id="editroleform" method="post">
		<fieldset>
		<h3><i class="mdi-content-create"></i> Current Active Roles</h3>
		<hr>
		<select class="form-control" name="role" id="role">	
		<?php 
			foreach($rolesArray as $row)
            	echo '<option value="'.$row['roleid'].'">'.$row['rolename']."</option>";
  			// foreach($results as $row)
  			// 	echo '<label><input type="radio" name="rolename" id="rolename'.$i++.'" value="'.$row['rolename'].'"><span class="circle"></span><span class="check"></span>'.$row['rolename'].'</label><br />';
  			echo '<br />';
  		?>
  		</div>
  		<div><hr style="margin-top: 0px;"></div>
  		<div class="text-center">
  		<input type="button" id="sub" class="btn btn-primary" value="Edit Role" onclick="editrole(<?php echo $i;?>);">
		</div>
		</fieldset>

	</form>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>

</body>