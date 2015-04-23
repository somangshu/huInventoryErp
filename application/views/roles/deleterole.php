<?php $this->load->view('common/menu'); ?>

<head>
    <title>
        <?php echo 'Delete Role';
        ?>
    </title>    
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
        <form class="form-horizontal" name="deleteroleform" id="deleteroleform" method="post">
            <fieldset>
            <h3><i class="mdi-social-person-add"></i> Delete role</h3>
             <div class="form-group">
              <div class="form-control-wrapper">
            <p>Delete role:</p>
            <select class="form-control" name="roleid" id="roleid"> 
                        <?php 
                            foreach($rolesArray as $role)
                                echo '<option value="'.$role['roleid'].'">'.$role['rolename']."</option>";
                        ?>
            </select>
         </div></div>
                     <div><hr></div>
            <div class="text-center">
                  <input type="button" class="btn btn-primary" id="sub" value="submit" onclick="deleterole();">
                </div>
                </fieldset>
        </form>
    </div>
  </div>
</div>

          <script src = "public/js/default.js"></script>
</body>
</html>