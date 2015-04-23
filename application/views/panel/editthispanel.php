<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo 'Edit Panel';
		?>
	</title>	
</head>
<body>
  <?php //var_dump($panelInfo);
      //die();
    ?>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
      	<form class="form-horizontal" name="editthispanelform" id="editthispanelform"  onsubmit="return updatepanel()" method="post">
      		<fieldset>
      		<h3><i class="mdi-social-person-add"></i> Edit Panel</h3>
          <div><hr></div>
            <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="panelid" id="panelid" value=<?php echo $panelInfo[0]['panel_id']; ?> readonly>
                  <div class="floating-label">Panel ID</div><span class="material-input"></span>
            </div>
            </div>
           <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="panelname" id="panelname" value=<?php echo $panelInfo[0]['panel_name']; ?>>
                  <div class="floating-label">Panel Name</div><span class="material-input"></span>
            </div>
            </div>
             <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="panelurl" id="panelurl" readonly value=<?php echo $panelInfo[0]['panel_url']; ?>>
                  <div class="floating-label">URL: </div><span class="material-input"></span>
            </div>
            </div>

             <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="textarea" name="paneldesc" id="paneldesc" value=<?php echo $panelInfo[0]['panel_description']; ?>>
                  <div class="floating-label">Panel Description: </div><span class="material-input"></span>
            </div>
            </div>
            <div class="form-group">
              <div class="form-control-wrapper">
          	<p>Panel type:</p>
          	<select class="form-control" name="type" id="type">	
            	<option value="display" <?php 
                                       if($panelInfo[0]['panel_type'] == 'display')
                                          echo 'selected';
                                      ?>>Display</option>
            	<option value="hidden" <?php 
                                      if($panelInfo[0]['panel_type'] == 'hidden')
                                          echo 'selected';
                                      ?>>Hidden</option>
      		</select>
      		</div></div>
      		 <div class="form-group">
              <div class="form-control-wrapper">
          	<p>Parent Panel:</p>
          	<select class="form-control" name="parent" id="parent">	
            			<?php 
            				$flag = 0;
                    $panelname = '';
                    foreach($panelsArray as $panel)
                    {
                      if($panel['panel_name'] == $panelInfo[0]['panel_name'])
                      {
                        foreach($panelsArray as $panelForName)
                        {
                            if($panel['panel_parent_id'] == $panelForName['panel_id'])
                            {
                                
                                echo '<option value="0">Home</option>';
                                $panelname = $panelForName['panel_name'];
                                echo '<option value="'.$panel['panel_id'].'" selected="selected">'.$panelname."</option>";
                                $flag = 1;
                                break;
                            }
                        }
                        if($flag)
                        {
                          $flag = 2;
                          break;
                        }
                      }
                    }
                    if($flag != 2)
                      echo '<option value="0" selected>Home</option>';
                    foreach($panelsArray as $panel)
                    {   
                      if($panel['panel_name'] != $panelname)
                        echo '<option value="'.$panel['panel_id'].'">'.$panel['panel_name']."</option>";
                    }
            					//echo '<option value="'.$panel['panel_id'].'">'.$panel['panel_name']."</option>";
            			?>
      		</select>
         </div></div>
                     <div><hr></div>
            <div class="text-center">
        		  <input type="button" class="btn btn-primary" id="sub" value="Edit Panel" onclick="updatepanel();">
        		</div>
        		</fieldset>
      	</form>
    </div>
  </div>
</div>

          <script src = "public/js/default.js"></script>
</body>
</html>