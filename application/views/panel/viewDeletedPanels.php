<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>
    
    <div class="main_content">
    
                    <?php $this->load->view('common/menu'); ?>            
                    
    <div class="center_content">  
    
    
    
     <?php //$this->load->view('common/leftMenu'); ?>  
    
    <div class="right_content">            
        
    <h2>Inactive Panels</h2> 
                    
                    
<table id="rounded-corner" >
    <thead>
    	<tr>
            <th scope="col" class="rounded">Panel</th>
            <th scope="col" class="rounded">Panel Status</th>
            <th scope="col" class="rounded">Date</th>
            <th scope="col" class="rounded">Edit</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($allPanelsArray as $temp){ ?>
    	<tr>
            <td><?php echo $temp['panel_name']; ?></td>
            <td>
            <?php if ($temp['panel_status']=='Yes') { ?>
            Active
            <?php } else if ($temp['panel_status']=='No') { ?>
            Inactive
            <?php } ?>
            </td>
            <td><?php echo $temp['panel_creationdate']; ?></td>

            <td><a href="/editPanel/<?php echo $temp['panel_id']; ?>"><img src="/public/images/user_edit.png" alt="" title="Edit Role" border="0" /></a></td>
        </tr>
    <?php } ?>            
    </tbody>
</table>

	 <a href="/createNewPanel" class="bt_green"><span class="bt_green_lft"></span><strong>Create new Panel</strong><span class="bt_green_r"></span></a>
     <a href="/viewAllPanels" class="bt_blue"><span class="bt_blue_lft"></span><strong>View all Panels</strong><span class="bt_blue_r"></span></a>
     <a href="/viewDeletedPanels" class="bt_red"><span class="bt_red_lft"></span><strong>View Inactive Panels</strong><span class="bt_red_r"></span></a> 
     
     
        
      
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
 <?php $this->load->view('common/footer'); ?>