<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo $title;?>
	</title>	
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
	<form name="deleteuserform" id="deleteuserform" onsubmit="return deleteuser()" method="post">
		<fieldset>
                    <h3><span style="padding-top: 4px;"><i class="mdi-action-delete"></i></span> Delete User Information</h3>
		<div><hr></div>
		<div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="email" name="username" id="username">
                  <div class="floating-label">User Name(Email-id):</div><span class="material-input"></span>
            </div>
            </div>
		
  		
  		<div><hr></div>
  		<div class="text-center">
  		<input type="button" id="sub" class="btn btn-primary" value="Delete User" onclick="deleteuser();">
  		</div>
  		</fieldset>
	</form>
	</div>
	</div>
</div>

		<script src = "public/js/default.js"></script>
</body>
</html>