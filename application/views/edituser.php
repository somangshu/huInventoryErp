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
	<form name="edituserform" id="edituserform" onsubmit="return editthisuser(<?php echo $i;?>)" method="post">
		<fieldset>
		<h3>Current Active Users</h3>
		<?php 
  			foreach($results as $row)
  				echo '<input type="radio" name="username" id="username'.$i++.'" value="'.$row['user_name'].'">'.$row['user_name'].'</input><br />';
  			echo '<br />';
  		?>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>
  		
  		<input type="button" id="sub" value="Edit User" onclick="editthisuser(<?php echo $i;?>);">
		</fieldset>
	</form>
</body>