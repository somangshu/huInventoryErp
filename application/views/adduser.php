<?php $this->load->view('common/menu'); ?>

<head>
	<title>
		<?php echo $title;
			  echo "hello";
		?>
	</title>	
</head>
<body>
<div class="formstyle container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="well bs-component">
      	<form class="form-horizontal" name="adduserform" id="adduserform"  onsubmit="return adduser()" method="post">
      		<fieldset>
      		<h3><i class="mdi-social-person-add"></i> Add User</h3>
          <div><hr></div>
           <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="email" name="username" id="username">
                  <div class="floating-label">User Name(Email-id)</div><span class="material-input"></span>
            </div>
            </div>
             <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="text" name="name" id="name">
                  <div class="floating-label">Name</div><span class="material-input"></span>
            </div>
            </div>

             <div class="form-group">
              <div class="form-control-wrapper"><input class="form-control empty" type="password" name="password" id="password">
                  <div class="floating-label">Password</div><span class="material-input"></span>
            </div>
            </div>
            <div class="form-group">
              <div class="form-control-wrapper">
          	<p>ROLES:</p>
          	<select class="form-control" name="role" id="role">	
            			<?php 
            				foreach($rolesArray as $row)
            					echo '<option value="'.$row['roleid'].'">'.$row['rolename']."</option>";
            			?>
      		      </select>
         </div></div>


      	<!--  	<br />
      		<br />
      		Panels:
      		<br />
      			<?php 
      				foreach($panelsArray as $row)
      					echo '<input type="checkbox" name="checklist[]" value="'.$row['panel_name'].'">'.$row['panel_name']."</checkbox><br />"
      			?>
        		</p>
        		-->
            
            <div><hr></div>
            <div class="text-center">
        		  <input type="button" class="btn btn-primary" id="sub" value="submit" onclick="adduser();">
        		</div>
        		</fieldset>
      	</form>
    </div>
  </div>
</div>

          <script src = "public/js/default.js"></script>
</body>
</html>