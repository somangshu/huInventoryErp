<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php 
			echo 'Get Tag';
		?>
	</title>	
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
	<form name="gettagform" id="gettagform" onsubmit="return false" method="post">
		<fieldset>
		<h3><i class="mdi-content-create"></i> Enter Tag</h3>
		<hr>
		<div class="form-group">
              <div class="form-control-wrapper">
              	<h3><b>#</b></h3><input class="form-control empty" type="text" name="tag" id="tag">
                  <div class="floating-label"></div>Tag Name<span class="material-input"></span>
            </div>
    </div>
  		<div><hr style="margin-top: 0px;"></div>
  		<div class="text-center">
  		<input type="button" id="sub" class="btn btn-primary" onclick="return updateimages()" value="Submit Tag">
		</div>
		</fieldset>

	</form>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "public/js/default.js"></script>

</body>