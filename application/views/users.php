<li>
	<a href="/userslink">Users</a>
	<ul>
	<?php 
		//$panelname = $this->session->userdata('childpanelname');
		//$paneldesc = $this->session->userdata('childpaneldesc');
		
		//var_dump($currentpanel);
		//var_dump($data);
		//die();
		
		$panelname = explode(',', $currentpanelname);
		$paneldesc = explode(',', $currentpaneldesc);
	
		for($i=0;$i<count($panelname)-1;$i++)
		{
			echo '<li><a href="/'.$panelname[$i].'">'.$paneldesc[$i].'</a></li>';
		}
	?>
	</li>
	<!--	
		<ul>
        		<li><a href="/adduser">Add user</a></li>
        		<li><a href="#">Delete user</a></li>
        		<li><a href="#">View active users</a></li>
        		<li><a href="#">Edit user</a></li>
    	</li>
   	-->
</ul>