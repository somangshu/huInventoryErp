<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>
    
    <div class="main_content">
    
                    <?php $this->load->view('common/menu'); ?> 
                    
                    
                    
                    
    <div class="center_content">  
    
    
    
    <?php //$this->load->view('common/leftMenu'); ?>
    
    <div class="right_content">            
           
     <div class="form">
         <h2 style="text-align:center">Edit Role</h2>
         <form action="/updateRole/<?php echo $roleDetailsArray[0]['role_id']; ?>" method="post" class="niceform">
         
                <fieldset>
                
                    <dl>
                        <dt><label for="role_name">Role Name:</label></dt>
                        <dd><input type="text" disabled onblur="this.value=this.value.toUpperCase()" name="role_name" id="role_name" value="<?php if (isset($roleDetailsArray[0]['role_name'])){ echo $roleDetailsArray[0]['role_name']; }?>" size="34" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="role_desc">Role Description:</label></dt>
                        <dd><textarea name="role_desc" id="role_desc" rows="5" cols="36"><?php if (isset($roleDetailsArray[0]['role_desc'])){ echo $roleDetailsArray[0]['role_desc']; }?></textarea></dd>
                    </dl>
                    <dl>
                        <dt><label for="role_status">Role Status:</label></dt>
                        <dd>
                            <select size="1" name="role_status" id="role_status">
                                <option <?php if(isset($roleDetailsArray[0]['role_status']) && $roleDetailsArray[0]['role_status']=='Yes'){ echo "selected='selected'"; } ?> value="Yes">Active</option>
                                	<option <?php if(isset($roleDetailsArray[0]['role_status']) && $roleDetailsArray[0]['role_status']=='No'){ echo "selected='selected'"; } ?> value="No">Inactive</option>
                            </select>
                        </dd>
                    </dl>
                     <dl class="submit" >
                     <dt></dt>
                     <dd style="width: 477px;">
                    <input type="submit" name="submit" id="submit" value="Submit" />
                    <a href="/viewActiveRoles" style="text-decoration: none;padding-left:10px;"><input type="button" name="Cancel" id="Cancel" value="Cancel" /></a>
                     </dd>
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
 <?php $this->load->view('common/footer'); ?>