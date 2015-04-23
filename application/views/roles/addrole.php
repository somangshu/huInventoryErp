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
                            <form class="form-horizontal" name="addroleform" id="addroleform" method="post">
                                <fieldset>
                                    <legend style="text-align: center;">Create New Role</legend>
                                    <div><hr></div>
                                    <div class="form-group">
                                        <div class="form-control-wrapper"><input class="form-control empty" id="rolename" type="text">
                                            <div class="floating-label">Role Name</div><span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-control-wrapper"><input class="form-control empty" id="roledesc" type="text">
                                            <div class="floating-label">Role Description</div><span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Role Status</label>
                                        <div class="col-lg-10">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""><span class="circle"></span><span class="check"></span>
                                                    Active
                                                </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"><span class="circle"></span><span class="check"></span>
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
                                                $flag = 0;
                                                for ($i=0; $i <= count($panelsArray) - 1; $i++)
                                                {     					  	
                                                    if ($panelsArray[$i]['panel_parent_id'] != $stack[$tos])
                                                        continue;
                                                    else 
                                                    {
                                                        $stack[++$tos] = $menuPanelsArray[$i]['panel_id'];
                                                        $panelsArray[$i]['panel_parent_id'] = -1;
                                                        $flag = 1;
                                                        $count++;
                                            ?>

                                            <li  class='active has-sub'>
                                            <div class="checkbox" style="padding-top: 0px !important;">
                                            <label>
                                            <?php $name = "panel".$j++; ?>
                                            <input type="checkbox" name="panel" id=<?php echo $name;?> value=<?php echo $panelsArray[$i]['panel_id']; ?>><?php echo $panelsArray[$i]['panel_name']; ?>
                                            </label>
                                            </div>
                                            <br/>
                                            <ul>
                                            <?php 
                                                        break;	
                                                    }
                                                }
                                                if(!$flag)
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
                                            <button onclick="addedrole();" class="btn btn-primary">Add Role</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                    </div>
                </div>
     </div>
     
    <script src = "./public/js/default.js"></script>
    <script src = "./public/jquery/jquery.checkboxtree.js"></script>
    <script>
    $('#checktree').checkboxTree();
    </script>
</body>