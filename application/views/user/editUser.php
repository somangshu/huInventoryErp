<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>
    
    <div class="main_content">
    
<?php $this->load->view('common/menu'); ?>
                                    
    <div class="center_content">  
    
     <?php //$this->load->view('common/leftMenu'); ?>  
    
    <div class="right_content">            
           
    
     
         <div class="form">
          <h2 style="text-align:center">Edit User</h2>
         <form action="/updateUser/<?php echo $userDetailsArray[0]['user_id']; ?>" method="post" class="niceform">
         
                <fieldset>
                    <dl>
                        <dt><label for="username">User Id:</label></dt>
                        <dd><input type="text" disabled name="username" id="username" value="<?php if (isset($userDetailsArray[0]['user_username'])){ echo $userDetailsArray[0]['user_username']; } ?>" size="34" /></dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="user_role">Select User Role:</label></dt>
                        <dd>
                            <select size="1" name="user_role" id="user_role">
                                <?php foreach ($allRolesArray as $temp){ ?>
                                	<option <?php if(isset($userDetailsArray[0]['role_id']) && $userDetailsArray[0]['role_id']==$temp['role_id']){ echo "selected='selected'"; } ?> value="<?php echo $temp['role_id']; ?>"><?php echo $temp['role_name']?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                    <dl>
                        <dt><label for="user_status">Select User Status:</label></dt>
                        <dd>
                            <select size="1" name="user_status" id="user_status">
                                	<option <?php if(isset($userDetailsArray[0]['user_status']) && $userDetailsArray[0]['user_status']=='Yes'){ echo "selected='selected'"; } ?> value="Yes">Active</option>
                                	<option <?php if(isset($userDetailsArray[0]['user_status']) && $userDetailsArray[0]['user_status']=='No'){ echo "selected='selected'"; } ?> value="No">Inactive</option>
                            </select>
                        </dd>
                    </dl>
                    <dl>
                        <dt><label for="user_description">User Description:</label></dt>
                        <dd><textarea name="user_description" id="user_description" rows="5" cols="36"><?php if (isset($userDetailsArray[0]['user_description'])){ echo $userDetailsArray[0]['user_description']; } ?></textarea></dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Submit" />
                    <a href="/viewActiveUsers" style="text-decoration: none;padding-left:10px;"><input type="button" name="Cancel" id="Cancel" value="Cancel" /></a>
                     </dl>
                      
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	 
 <?php $this->load->view('common/footer'); ?>