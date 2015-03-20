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
	<form name="adduserform" id="activeusers" onsubmit="return adduser()" method="post">
		<fieldset>
		<h3><i class="mdi-action-alarm-on"></i> Active User Information</h3>
		<div><hr></div>
		<ol>
		<?php 
  			foreach($results as $row)
  				echo '<li>'. $row['user_name'].'</li>';
  		?>
  		</ol>
		</fieldset>
	</form>
	</div>
</div>
</div>
</body>