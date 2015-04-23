<?php $this->load->view('common/menu'); ?>

<head>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
	<form name="searchform" id="searchform" onsubmit="return false" method="post">
		<fieldset>
		<h3><i class="mdi-content-create"></i> Enter Tag</h3>
		<hr>
		<div class="form-group">
              <div class="form-control-wrapper">
              	<h3><b>#</b></h3><input class="form-control empty" type="text" name="tag" id="tag">
                  <div class="floating-label"></div>Tag Name<span class="material-input"></span>
            </div>
    </div>
    <h3><i class="mdi-content-create"></i> Choose Source(if any)</h3>
    <div class="radio radio-primary">
		<?php 
  		echo '<label><input type="radio" name="source" id="source1" value="None" checked><span class="circle"></span><span class="check"></span>Either</label><br /><br />';
  		echo '<label><input type="radio" name="source" id="source2" value="Web"><span class="circle"></span><span class="check"></span>Web</label><br /><br />';
  		echo '<label><input type="radio" name="source" id="source3" value="inhouse"><span class="circle"></span><span class="check"></span>In-House</label><br /><br />';
  		?>
  	</div>
  	<div>

<label>Date</label>
<div class="input-append">
    <input class="date-picker" id="date" name="date" htype="text" />
    <label for="date" class="add-on"><i class="mdi-content-create"></i> </label>
</div>
  		<div><hr style="margin-top: 0px;"></div>
  		<div class="text-center">
  		<input type="button" id="sub" class="btn btn-primary" onclick="return search()" value="Submit">
		</div>
		</fieldset>

	</form>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src = "public/js/default.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>
</body>