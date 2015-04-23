<html>
<head>
    <title> Home Page </title>
    <link href="/public/css/styles.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src = "public/js/default.js"></script>
</head>
<body>
    <div id="cssmenu">
    <ul>
    	<?php 
    		$panels = $this->session->userdata('panels');
			
    		$panelsname = explode(',', $panels);
    		
    		for($i=0;$i<$panelsArray['count'];$i++)
    		{
    			var_dump($i);
    			var_dump($panelsArray[$i]);
				
    			//$data['currentpanelname'] = $panelsArray[$i]['users']['childpanelname'];
    			//$data['currentpaneldesc'] = $panelsArray[$i]['users']['childpaneldesc'];
    			 
    			//$displayData['currentpanel'] = $data;
    			
    			$this->load->view($panelsname[$i]);
    		}
    	?>
        <!--<li><a href="#">My account</a><ul>
        	<li><a href="#">Users</a><ul>
        		<li><a href="/adduser">Add user</a></li>
        		<li><a href="#">Delete user</a></li>
        		<li><a href="#">View active users</a></li>
        		<li><a href="#">Edit user</a></li>
        	</li></ul>
        	<li><a href="#">Panels</a><ul>
        		<li><a href="/addpanel">Add panel</a></li>
        		<li><a href="#">Delete panel</a></li>
        	</li></ul>
        	<li><a href="#">Groups/Roles</a><ul>
        		<li><a href="/addrole">Add group</a></li>
        		<li><a href="#">Delete group</a></li>
        	</li></ul>
        	<li><a href="#">Access management</a></li>
        </li></ul>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">View order</a></li>-->
    </ul>
    </div>

    <div id="main-content">
        <?php $this->load->view($content); ?>
    </div>

    <div id="footer">
        Happily Unmarried
    </div>
</body>
</html>
