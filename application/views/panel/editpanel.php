<?php $this->load->view('common/menu'); ?>

<head>
    <title>
        <?php echo 'Edit Panel';
        ?>
    </title>    
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
        <form class="form-horizontal" name="editpanelform" id="editpanelform"  onsubmit="return editpanel();" method="post">
            <fieldset>
            <h3><i class="mdi-social-person-add"></i> Edit Panel</h3>
             <div class="form-group">
              <div class="form-control-wrapper">
            <p>Edit Panel:</p>
            <select class="form-control" name="panelid" id="panelid"> 
                        <?php 
                            foreach($panelsArray as $panel)
                                echo '<option value="'.$panel['panel_id'].'">'.$panel['panel_name']."</option>";
                        ?>
            </select>
         </div></div>
                     <div><hr></div>
            <div class="text-center">
                  <input type="button" class="btn btn-primary" id="sub" value="edit" onclick="editpanel();">
                </div>
                </fieldset>
        </form>
    </div>
  </div>
</div>

          <script src = "public/js/default.js"></script>
</body>
</html>