<?php 
$this->load->view('/common/menu');
?>

<head>
    <meta charset="UTF-8">
	<title>
		<?php
			echo $title;
		?>
	</title>
</head>
<body>
	<?php 
		$stack[100] = array();
		$tos = -1;
		$stack[++$tos] = "0";
		$count = 0;
        $j = 0;
	?>

    <div class="formstyle container">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="well bs-component">
        <form name="editroleform" id="editroleform" method="post">
            <fieldset>
            <input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>">;
            <h3><i class="mdi-content-create"></i> Current Active Roles</h3>
            <hr>
            <select class="form-control" name="role" id="role"> 
            <?php 
                foreach($rolesArray as $row)
                {
                    if($roleInfo[0]['rolename'] == $row['rolename'])
                        echo '<option value="'.$row['roleid'].'" selected="selected">'.$row['rolename']."</option>";
                    else
                        echo '<option value="'.$row['roleid'].'">'.$row['rolename']."</option>";
                }
                
                echo '<br />';
            ?>
            </div>
            <div><hr style="margin-top: 0px;"></div>
            <div class="text-center">
            <input type="button" id="sub" class="btn btn-primary" value="Edit Role" onclick="editrole();">
            </div>
            </fieldset>

        </form>
    </div>
    </div>
    </div>
    <?php
        if($flag)
        {
    ?>
            <div class="formstyle container">
                <div class="col-sm-8 col-sm-offset-2">
                        <div class="well bs-component">
                            <!-- <form class="form-horizontal" name="editthisroleform" id="editthisroleform" method="post"> -->
                                <fieldset>
                                    <legend style="text-align: center;">Edit Role</legend>
                                    <div><hr></div>
                                    <div class="form-group">
                                        <div class="form-control-wrapper"><input class="form-control empty" id="roleid" type="text" value="<?php echo $roleInfo[0]['roleid']; ?>" readonly>
                                            <div class="floating-label">Role ID</div><span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-control-wrapper"><input class="form-control empty" id="rolename" type="text" value="<?php echo $roleInfo[0]['rolename']; ?>">
                                            <div class="floating-label">Rolename</div><span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-control-wrapper"><input class="form-control empty" id="roledesc" type="text" value="<?php echo $roleInfo[0]['role_description']; ?>">
                                            <div class="floating-label">Role Description</div><span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Role Status</label>
                                        <div class="col-lg-10">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" <?php 
                                                    if($roleInfo[0]['isactive'])
                                                        echo 'checked';
                                                                    ?>>
                                                    <span class="circle"></span>
                                                    <span class="check"></span>
                                                    Active
                                                </label>
                                            </div>
                                            <br/ >
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" <?php 
                                                    if(!$roleInfo[0]['isactive'])
                                                        echo 'checked';
                                                                    ?>>
                                                    <span class="circle"></span>
                                                    <span class="check"></span>
                                                    Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Panels</label>
                                        <div class="col-lg-10">
                                            <ul id="checktree">
                                            <?php 
                                            while($count != count($panelsArray) - 1)
                                            {	
                                                $flaginner = 0;
                                                for ($i=0; $i <= count($panelsArray) - 1; $i++)
                                                {     					  	
                                                    if ($panelsArray[$i]['panel_parent_id'] != $stack[$tos])
                                                        continue;
                                                    else 
                                                    {
                                                        $stack[++$tos] = $menuPanelsArray[$i]['panel_id'];
                                                        $panelsArray[$i]['panel_parent_id'] = -1;
                                                        $flaginner = 1;
                                                        $count++;
                                            ?>

                                            <li  class='active has-sub'>
                                            <div class="checkbox" style="padding-top: 0px !important;">
                                            <label>
                                            <input 
                                            type="checkbox" 
                                            name="panel" 
                                            value="<?php 
                                                    echo $panelsArray[$i]['panel_id']; 
                                                    ?>"
                                            id=<?php 
                                                    echo "panel".$j++;
                                                ?>

                                            <?php 
                                                    if(in_array($panelsArray[$i]['panel_id'], $roleInfo[1]))
                                                        echo 'checked';
                                                    
                                            ?>
                                            ><?php echo $panelsArray[$i]['panel_name']; ?></input>
                                            </label>
                                            </div>
                                            <br/>
                                            <ul>
                                            <?php 
                                                        break;	
                                                    }
                                                }
                                                if(!$flaginner)
                                                {
                                                    --$tos;

                                            ?>
                                            </ul>
                                            </li>
                                            <?php 
                                                }
                                            }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div><hr></div>
                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <button class="btn btn-default">Cancel</button>
                                            <button onclick="updaterole();" class="btn btn-primary">Update Role</button>
                                        </div>
                                    </div>
                                </fieldset>
                            <!-- </form> -->
                    </div>
                </div>
     </div>
    <?php
        }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src = "./public/js/default.js"></script>
    <script src = "./public/jquery/jquery.checkboxtree.js"></script>
    <script>
    $('#checktree').checkboxTree();
    </script>
</body>