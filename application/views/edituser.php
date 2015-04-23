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
	<form name="edituserform" id="edituserform" onsubmit="return editthisuser(<?php echo $i;?>)" method="post">
		<fieldset>
		<h3><i class="mdi-content-create"></i> Current Active Users</h3>
		<hr>
		<div class="radio radio-primary">
		<?php 
  			foreach($results as $row)
  				echo '<label><input type="radio" name="username" id="username'.$i++.'" value="'.$row['user_name'].'"><span class="circle"></span><span class="check"></span>'.$row['user_name'].'</label><br />';
  			echo '<br />';
  		?>
  		</div>
  		<div><hr style="margin-top: 0px;"></div>
  		<div class="text-center">
  		<input type="button" id="sub" class="btn btn-primary" value="Edit User" onclick="editthisuser(<?php echo $i;?>);">
		</div>
		</fieldset>

	</form>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>

</body>