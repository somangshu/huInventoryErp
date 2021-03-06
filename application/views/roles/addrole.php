<?php $this->load->view('common/menu'); ?>

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
	?>
<div class="formstyle">
                <div class="col-lg-6">
                        <div class="well bs-component">
                            <form class="form-horizontal" name="addroleform" id="addroleform" onsubmit="return addrole()" method="post">
                                <fieldset>
                                    <legend style="text-align: center;">Create new role</legend>
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
                                            while($count < count($panelsArray))
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
                                            <input type="checkbox" name="panel" value=<?php echo $panelsArray[$i]['panel_name']; ?>><?php echo $panelsArray[$i]['panel_name']; ?>
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
     
    <script src = "public/js/default.js"></script>
    <script src = "./public/jquery/jquery.checkboxtree.js"></script>
    <script>
    $('#checktree').checkboxTree();
    </script>
</body>