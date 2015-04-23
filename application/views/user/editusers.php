<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php 
			echo $title;
		?>
	</title>	
</head>
<body>
	<form name="adduserform" id="adduserform" onsubmit="return adduser()" method="post">
		<fieldset>
		<h3>Active User Information</h3>
		<?php 
  			foreach($results as $row)
  				echo $row['user_name'].'<br />';
  		?>
		</fieldset>
	</form>
</body>