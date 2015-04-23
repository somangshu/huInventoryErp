<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo 'Add Panel';
		?>
	</title>	
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
      	<form class="form-horizontal" name="addpanelform" id="addpanelform"  onsubmit="return addpanel()" method="post">
      		<fieldset>
      		<h3><i class="mdi-social-person-add"></i> Add Panel</h3>
          <div><hr></div>
           <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="panelname" id="panelname">
                  <div class="floating-label">Panel Name: </div><span class="material-input"></span>
            </div>
            </div>
             <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="panelurl" id="panelurl">
                  <div class="floating-label">URL: </div><span class="material-input"></span>
            </div>
            </div>

             <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="textarea" name="paneldesc" id="paneldesc">
                  <div class="floating-label">Panel Description: </div><span class="material-input"></span>
            </div>
            </div>
            <div class="form-group">
              <div class="form-control-wrapper">
          	<p>Panel type:</p>
          	<select class="form-control" name="type" id="type">	
            	<option value="display" selected>Display</option>
            	<option value="hidden">Hidden</option>
      		</select>
      		</div></div>
      		 <div class="form-group">
              <div class="form-control-wrapper">
          	<p>Parent Panel:</p>
          	<select class="form-control" name="parent" id="parent">	
            			<?php 
            				echo '<option value="0">Home</option>';
            				foreach($panelsArray as $panel)
            					echo '<option value="'.$panel['panel_id'].'">'.$panel['panel_name']."</option>";
            			?>
      		</select>
         </div></div>
                     <div><hr></div>
            <div class="text-center">
        		  <input type="button" class="btn btn-primary" id="sub" value="submit" onclick="addpanel();">
        		</div>
        		</fieldset>
      	</form>
    </div>
  </div>
</div>

          <script src = "public/js/default.js"></script>
</body>
</html>