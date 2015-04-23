<?php 
	$this->load->view('/common/menu'); 
?> 
<div class="well well-lg" style="width: 31%;margin: 2% 0 0 34% !important;text-align: center;">
    <h1>Welcome <span style="font-size: .5em;vertical-align: middle;"><?php 
			if (isset($sessionUserData['user_name']))
			{ 
                            echo $sessionUserData['user_name']; }?>!</span></h1>
    <p class="lead">
What would <b>you</b> like to do today?
    </p>
</div>