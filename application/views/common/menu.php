<!DOCTYPE>
<html>
<body>
<head>
    <meta charset="UTF-8">
    <title> Home Page </title>
    <link href="/public/css/styles.css" type="text/css" rel="stylesheet" />
    <link href="/public/css/bootstrap.css" rel="stylesheet">
    <link href="/public/css/ripples.css" rel="stylesheet">
    <link href="/public/css/material-wfont.css" rel="stylesheet">
    <link href="/public/css/bootstrap.css.map" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>                         
<div id="cssmenu" class="bs-component" >
<div class="navbar navbar-default">
<div class="container">  
 <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a href="/" style="padding: 0px !important;"><span class="navbar-brand logo"><img src="public/images/logo.png"></span></a>
	<?php 
		$stack[100] = array();
		$tos = -1;
		$stack[++$tos] = "0";
		$count = 0;
		
	?>
                                </div>

  <div class="navbar-collapse collapse navbar-responsive-collapse">
	<ul>
		<?php
		while($count != count($menuPanelsArray)-1)
		{	
			$flag = 0;
			for ($i=0; $i <= count($menuPanelsArray) - 1; $i++)
			{     					  	
				if ($menuPanelsArray[$i]['panel_parent_id'] != $stack[$tos])
					continue;
			  	else 
              	{
              		$stack[++$tos] = $menuPanelsArray[$i]['panel_id'];
              		$menuPanelsArray[$i]['panel_parent_id'] = -1;
              		$flag = 1;
              		$count++;
        ?>
		
		<li class=''><a class="current" href="<?php echo $menuPanelsArray[$i]['panel_url']; ?>"
			title="<?php echo $menuPanelsArray[$i]['panel_name']; ?>"><?php echo $menuPanelsArray[$i]['panel_name']; ?>
		</a>
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
	</ul>
		<li>
		<a class="current" href="#"><?php 
			if (isset($sessionUserData['user_name']))
			{ 
				echo $sessionUserData['user_name']; } ?>

				</a><ul><li style="width: 135px;"><a class="current" href="/logout">Logout</a></li></ul>
		</li>
		</div>

		</div>
</div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type="text/javascript" src = "/public/js/default.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/public/js/ripples.js"></script>
<script type="text/javascript" src="/public/js/material.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.4.0/less.js"></script>

         <script>
        	  $(document).ready(function() {
                 $.material.init();
             });
         </script>

</body>
</html>