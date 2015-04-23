<?php $this->load->view('common/menu'); ?>

<head>
    <title>
        <?php echo 'Delete Panel';
        ?>
    </title>    
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
        <form class="form-horizontal" name="deletepanelform" id="deletepanelform"  onsubmit="return deletepanel();" method="post">
            <fieldset>
            <h3><i class="mdi-social-person-add"></i> Delete Panel</h3>
             <div class="form-group">
              <div class="form-control-wrapper">
            <p>Delete Panel:</p>
            <select class="form-control" name="panelid" id="panelid"> 
                        <?php 
                            foreach($panelsArray as $panel)
                                echo '<option value="'.$panel['panel_id'].'">'.$panel['panel_name']."</option>";
                        ?>
            </select>
         </div></div>
                     <div><hr></div>
            <div class="text-center">
                  <input type="button" class="btn btn-primary" id="sub" value="submit" onclick="deletepanel();">
                </div>
                </fieldset>
        </form>
    </div>
  </div>
</div>

          <script src = "public/js/default.js"></script>
</body>
</html>