<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>
    
    <div class="main_content">
    
                    <?php $this->load->view('common/menu'); ?>            
                    
    <div class="center_content">  
    
    
    
     <?php //$this->load->view('common/leftMenu'); ?>  
    
    <div class="right_content">            
        
    <h2>Inactive Users</h2> 
                    
                    
<table id="rounded-corner">
    <thead>
    	<tr>
            <th scope="col" class="rounded">User</th>
            <th scope="col" class="rounded">User Role</th>
            <th scope="col" class="rounded">User Status</th>
            <th scope="col" class="rounded">Date</th>
            <th scope="col" class="rounded">Edit</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($allUsersArray as $temp){ ?>
    	<tr>
            <td><?php echo $temp['user_username']; ?></td>
            <td><?php echo $temp['role_name']; ?></td>
            <td>
            <?php if ($temp['user_status']=='Yes') { ?>
            Active
            <?php } else if ($temp['user_status']=='No') { ?>
            Inactive
            <?php } ?>
            </td>
            <td><?php echo $temp['user_creationdate']; ?></td>

            <td><a href="/editUser/<?php echo $temp['user_id']; ?>"><img src="/public/images/user_edit.png" alt="" title="Edit User" border="0" /></a></td>
        </tr>
    <?php } ?>            
    </tbody>
</table>

	 <a href="/createNewUser" class="bt_green"><span class="bt_green_lft"></span><strong>Create New User</strong><span class="bt_green_r"></span></a>
     <a href="/viewAllUsers" class="bt_blue"><span class="bt_blue_lft"></span><strong>View all Users</strong><span class="bt_blue_r"></span></a>
     <a href="/viewDeletedUsers" class="bt_red"><span class="bt_red_lft"></span><strong>View Inactive Users</strong><span class="bt_red_r"></span></a> 
     
     
        <!-- <div class="pagination">
        <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>…<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
        </div>--> 
      
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
 <?php $this->load->view('common/footer'); ?>