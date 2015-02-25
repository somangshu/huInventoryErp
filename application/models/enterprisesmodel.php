<?php 

class Enterprisesmodel extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
    
    public function init()
    {
        $dbHandle = $this->load->database('default', TRUE);
        if($dbHandle == '')
        {
            error_log('can not create db handle','qna');
            echo (print_r($dbHandle,true));
        }
        return $dbHandle;
    }


	public function insertInstagramImages($query)
    {
        $dbHandle = $this->init();
        $result = mysql_query($query);

        if($result)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    public function doValidateLogin($username,$password)
    {
    	$dbHandle = $this->init();
    	$query = "SELECT user_id,user_name,user_email,user_password,active,user_roleid FROM users 
    			  WHERE LOWER(user_email) = '".$username."' AND user_password='".$password."' AND active='1'";
    	$result = mysql_query($query);
    	$userData=array();
    	if(mysql_num_rows($result) >0){
    		$row=mysql_fetch_assoc($result);
    		$userData=$row;
    	}
    	
    	return $userData;
    }

    public function getAllPanelsByRole($role_id){
    	$dbHandle = $this->init();
    	
    	$query = "SELECT a.roleid,a.rolename,b.panel_id,b.panel_name,b.panel_url,b.panel_description,b.panel_parent_id,b.panel_type FROM roles a,panels b,role_panel_mapping c WHERE a.roleid='".$role_id."' AND b.panel_type='display'
				  AND a.roleid=c.roleid and b.panel_id=c.panel_id Order by panel_id ASC";
    	error_log("Query is ".$query);
    	
    	$result = mysql_query($query);
    	$panelsArray = array();
    	
    	$i=0;
    	
    	while($row = mysql_fetch_assoc($result))
    	{
    		$panelsArray[$i] = $row;
    		$i++;
    	} 
    	return $panelsArray;
    }

    
    public function addUser($data)
    {
    	$dbHandle = $this->init();
    	 
    	$query = "INSERT INTO users(user_name, user_email, user_password, user_roleid, created_at,updated_at,active) 
    			VALUES ('".$data['name']."','".$data['username']."','".$data['password']."','".$data['role']."',NOW(),NOW(),'1')";
    	
    	
    	$result = mysql_query($query);
    	
    }
    public function addrole($data)
    {	
    	$dbHandle = $this->init();
    	
    	$query = "INSERT INTO roles(rolename, role_description, isactive) VALUES ('";
    	$query .= $data['rolename']."', '";
    	$query .= $data['roledesc']."', '";
    	$query .= $data['isactive']."');";
    	    	
    	$result = mysql_query($query);
    	
    	$query = "SELECT roleid FROM roles where rolename='".$data['rolename']."'";
    	$result = mysql_query($query);
    	$row = mysql_fetch_assoc($result);
    	$roleid = $row['roleid'];
    	

    	$data['param'] = rtrim($data['param'], " ");
    	$panelid = explode(" ",$data['param']);
    	$query = "";
    	for($count = 0; $count < count($panelid); $count++)
    	{
    		$query= "INSERT INTO role_panel_mapping (roleid, panel_id) VALUES ('".$roleid."', '".$panelid[$count]."');";
    		mysql_query($query);
    	}
    }
    
    public function addpanel($data)
    {
    	$dbHandle = $this->init();
    	$query = "INSERT INTO panel(panel_name, panel_url, panel_description, panel_parent_id, panel_type) VALUES ('";
    	$query .= $data['panelname']."', '";
    	$query .= $data['panelurl']."', '";
    	$query .= $data['paneldesc']."', '";
    	$query .= $adata['panelparent']."', '";
    	$query .= $data['paneltype']."')";
    			
    	$result = mysql_query($query);
    }
    
    public function getrolesandpanels()
    {
    	$dbHandle = $this->init();
    	
    	$query = "SELECT rolename FROM roles";
    	$result = mysql_query($query);
    	$data = array();
    	
    	$rolesArray = array();
        $i=0;
        
        if($result && mysql_num_rows($result) > 0)
        {
            while($row = mysql_fetch_assoc($result))
            {
                $rolesArray[$i]=$row;
                $i++;
            }
            $data['rolesArray'] = $rolesArray;
        }
        
        $query = "SELECT panel_name FROM panel";
        $result = mysql_query($query);
         
        $panelsArray = array();
        $i=0;
        
        if($result && mysql_num_rows($result) > 0)
        {
        	while($row = mysql_fetch_assoc($result))
        	{
        		$panelsArray[$i]=$row;
        		$i++;
        	}
        	$data['panelsArray'] = $panelsArray;
        }
        return $data;
    }
    
    public function getrole($username)
    {
    	$query = "SELECT userid FROM users WHERE users.emailid='".$username."';";
    	$result = mysql_query($query);
    	$row = mysql_fetch_assoc($result);
    	$userid = $row['userid'];
    	
    	$query = "SELECT roleid FROM user_role_mapping WHERE user_role_mapping.userid='".$userid."';";
    	$result = mysql_query($query);
    	$row = mysql_fetch_assoc($result);
    	$roleid = $row['roleid'];

    	$query = "SELECT GROUP_CONCAT(panelid separator ',') from role_panel_mapping where roleid=".$roleid." group by 'all'";
    	$result = mysql_query($query);
    	$panels = mysql_fetch_assoc($result);
    	$panelsid = $panels["GROUP_CONCAT(panelid separator ',')"];
    	
    	$panelsid=explode(',', $panelsid);
    	
    	$panelname = '';
    	
    	foreach($panelsid as $panel)
    	{
    		$query = "SELECT panel_name FROM panel WHERE panel.panel_id='".$panel."';";
    		$result = mysql_query($query);
    		$row = mysql_fetch_assoc($result);
    		$panelname .= $row['panel_name'].",";
    	}
    	$this->session->set_userdata('panels', $panelname);
    }
    
    public function getchildpanels($panelname)
    {
    	$query = "SELECT panel_id FROM panel WHERE panel.panel_name='".$panelname."';";
    	$result = mysql_query($query);
    	$row = mysql_fetch_assoc($result);
    	$panelid = $row['panel_id'];
    	
    	//we now have the id of the parent->get the kids associated with this->group them
    	$query = "SELECT GROUP_CONCAT(panel_id separator ',') from panel where panel.panel_parent_id=".$panelid." group by 'all'";
    	$result = mysql_query($query);
    	$panels = mysql_fetch_assoc($result);
    	$panelsid = $panels["GROUP_CONCAT(panel_id separator ',')"];
    	$childpanels;
    	
    	$panelsid=explode(',', $panelsid);
    	 
    	$panelname = '';
    	$childpanelname = '';
    	$childpaneldesc = '';
    	foreach($panelsid as $panel)
    	{
    		$query = "SELECT panel_name, panel_description FROM panel WHERE panel.panel_id='".$panel."';";
    		$result = mysql_query($query);
    		$row = mysql_fetch_assoc($result);
    		$childpanelname .= $row['panel_name'].",";
    		$childpaneldesc .= $row['panel_description'].",";
    	}   	
    	
    	$childpanels['childpanelname'] = $childpanelname;
    	$childpanels['childpaneldesc'] = $childpaneldesc;
    	 
    	return $childpanels;
       	//$this->session->set_userdata('childpanelname', $childpanelname);
    	//$this->session->set_userdata('childpaneldesc', $childpaneldesc);
    }


public function authenticate($post){
	$dbHandle = $this->init();
	if (isset($post['username'])){
		$username=$post['username'];
	}else{
		$username='';
	}
	$username = strtolower($username);
	if (isset($post['password'])){
		$password=base64_encode($post['password']);
	}else {
		$password='';
	}
	
	$query = "SELECT * FROM users where LCASE(email_id)='$username' and user_password='$password' and active='1'";
	//echo $query;
	$result = mysql_query($query);
	$userArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$userArray[$i] = $row;
		$i++;
	}
	//var_dump($userArray);
	if ($i > 0){
		$query = "update user_tbl set last_login = NOW() where LCASE(user_username)='$username' and user_password='$password'";
		mysql_query($query);

	}
	return $userArray;
}

public function checkDepartment($userId,$passwd)
{
	$dbHandle = $this->init();
	$userId2 = strtolower($userId);
	$password=base64_encode($passwd);
	$query = "select department from user_tbl where LCASE(user_username)='$userId2' and user_password='$password'";
	$result = mysql_query($query);
	if($result && mysql_num_rows($result)>0){
		$row = mysql_fetch_assoc($result);
		$dept = $row['department'];
		if($dept!=""){
			return 1;
		}else{
			return 0;
		}
	}else{
		return 2;
	}
}

public function fetchDepartment()
{
	$dbHandle = $this->init();
	$query = "SELECT reason FROM reasons_admin WHERE category ='department'";
	$result = mysql_query($query);
	$department = array();
	$i=0;
	if($result && mysql_num_rows($result)>0){
		while($row = mysql_fetch_assoc($result)){
			$department[$i]=$row;
			$i++;
		}
		return $department;
	}else{
		return 0;
	}
}

public function fillDepartment($post)
{
	$dbHandle = $this->init();
	if (isset($post['username'])){
		$username=$post['username'];
	}else{
		$username='';
	}
	if (isset($post['password'])){
		$password=base64_encode($post['password']);
	}else {
		$password='';
	}
	$dept = $post['selDept'];
	if($dept=="Other"){
		$dept = $post['selOther'];
	}
	$cZentrixDialerId = "";
	if(trim($post['cZentrix'])!=""){
		$cZentrixDialerId = ", c_zentrix_dialler_id='".$post['cZentrix']."'";
	}
	$query = "update user_tbl set department='$dept' $cZentrixDialerId where LCASE(user_username)='$username' and user_password='$password'";
	$result = mysql_query($query);
}

public function updatePassword($post){
	$dbHandle = $this->init();
	if (isset($post['username'])){
		$username=$post['username'];
	}else{
		$username='';
	}
	$query = "SELECT * FROM user_tbl where user_username='$username' and user_status='Yes'";
	$result = mysql_query($query);
	$userArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$userArray[$i] = $row;
		$i++;
	}
	return $userArray;
}

public function updateNewPassword($post){
	$dbHandle = $this->init();
	if (isset($post['password'])){
		$password=base64_encode($post['password']);
	}else{
		$password='';
	}
	if (isset($post['username'])){
		$username=$post['username'];
	}else{
		$username='';
	}
	$query = "update user_tbl set user_password='$password', passworddate = NOW() where user_username='$username'";
	$result = mysql_query($query);
	if($result){
		return true;
	}else{
		return false;
	}

}

public function getUserDetailsByEmail($email){
	$dbHandle = $this->init();
	$query = "SELECT * FROM user_tbl where user_username='$email' and user_status='Yes'";
	$result = mysql_query($query);
	$userArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$userArray[$i] = $row;
		$i++;
	}
	return $userArray;
}

public function insertRolePanelMapping($post){
	$dbHandle = $this->init();
	$query = "delete from role_panel_mapping where role_id='".$post['role_id']."'";
	$result = $dbHandle->query($query);
	foreach ($post['permission'] as $temp){
		$query = "insert into role_panel_mapping(role_id, panel_id) values('".$post['role_id']."', '".$temp."')";
		$result = $dbHandle->query($query);
	}
}

public function getPanelsByRole($role_id){
	$dbHandle = $this->init();
	$query="SELECT panel_id FROM role_panel_mapping where role_id='$role_id'";
	error_log("query is ".$query);
	$result = mysql_query($query);
	$rolePanelArray = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($rolePanelArray, $row['panel_id']);
	}
	//error_log(print_r($usersArray));
	return $rolePanelArray;
}

//------------------USERS-------------------------------------------

public function getAllUsers($user_status){
	$dbHandle = $this->init();
	$query="SELECT u.*, r.* FROM user_tbl u, role_tbl r where u.user_role_id=r.role_id ";
	if($user_status!='0'){
		$query .= " and u.user_status='$user_status'";
	}
	$query .= " order by u.user_status";
	//echo $query;
	$result = mysql_query($query);
	$allUsersArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$allUsersArray[$i] = $row;
		$i++;
	}
	//error_log(print_r($usersArray));
	return $allUsersArray;
}

public function getUserDetails($user_id){
	$dbHandle = $this->init();
	$query = "SELECT u.*, r.* FROM user_tbl u, role_tbl r where u.user_role_id=r.role_id and u.user_id='$user_id'";
	$result = mysql_query($query);
	$usersDetailsArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$usersDetailsArray[$i] = $row;
		$i++;
	}
	return $usersDetailsArray;
}

public function getAllRoles(){
	$dbHandle = $this->init();
	$query = "SELECT * FROM roles WHERE isactive='1' order by rolename";
	
	$result = mysql_query($query);
	
	$rolesArray = array();
	
	$i=0;
	while($row = mysql_fetch_assoc($result))
	{
		$rolesArray[$i] = $row;
		$i++;
	}
		
	return $rolesArray;
}

public function getAllPanels(){
	$dbHandle = $this->init();
	$query = "SELECT * FROM panels";

	$result = mysql_query($query);
	$panelsArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result))
	{
		$panelsArray[$i] = $row;
		$i++;
	}
	
	return $panelsArray;
}



public function getMainPanels($panel_status){
	$dbHandle = $this->init();
	$query = "SELECT * FROM panel_tbl where panel_parent_id=0";
	if($panel_status!='0'){
		$query .= " and panel_status='$panel_status'";
	}
	$query .= " order by panel_id";
	error_log("query is ".$query);
	$result = mysql_query($query);
	$panelsArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$panelsArray[$i] = $row;
		$i++;
	}
	return $panelsArray;
}
public function getAccessRole($action,$role_id)
{
	$dbHandle = $this->init_inventory();
	$result=mysql_query("SELECT role_id FROM access_management WHERE action='".$action."' AND role_id='$role_id'");
	if($result && mysql_num_rows($result)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

public function deletePanel($panel_id){
	$dbHandle = $this->init();
	$query = "update panel_tbl set panel_status='No' where panel_id='$panel_id'";
	$result = $dbHandle->query($query);
	if($result)
	{
		return true;
	}
	else
	{return false;
	}
}

public function deleteRole($role_id){
	$dbHandle = $this->init();
	$query = "update role_tbl set role_status='No' where role_id='$role_id'";
	$result = $dbHandle->query($query);
	if($result)
	{
		return true;
	}
	else
	{return false;
	}
}

public function getRoleDetails($role_id){
	$dbHandle = $this->init();
	$query = "SELECT * FROM role_tbl where role_id='$role_id'";
	$result = mysql_query($query);
	$rolesDetailsArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$rolesDetailsArray[$i] = $row;
		$i++;
	}
	//error_log(print_r($usersArray));
	return $rolesDetailsArray;
}

public function getPanelDetails($panel_id){
	$dbHandle = $this->init();
	$query = "SELECT * FROM panel_tbl where panel_id='$panel_id'";
	$result = mysql_query($query);
	$panelDetailsArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$panelDetailsArray[$i] = $row;
		$i++;
	}
	//error_log(print_r($usersArray));
	return $panelDetailsArray;
}

public function getPanelDetailsByUrl($panel_url){
	$dbHandle = $this->init();
	$query = "SELECT * FROM panel_tbl where panel_url='$panel_url' and panel_status='Yes'";
	$result = mysql_query($query);
	$panelDetailsArray = array();
	$i=0;
	while($row = mysql_fetch_assoc($result)){
		$panelDetailsArray[$i] = $row;
		$i++;
	}
	//error_log(print_r($usersArray));
	return $panelDetailsArray;
}

public function updaterole($post)
{
	$dbHandle = $this->init();
	
	$query1 = "update roles set role_description='".$post['roledesc']."'"."where roleid='".$post['roleid']."'";
	$result1 = $dbHandle->query($query1);
	
	$query2 = "update roles set rolename='".$post['rolename']."' where roleid='".$post['roleid']."'";
	$result2 = $dbHandle->query($query2);
	
	if($result1 && $result2)
	{
		$post['param'] = rtrim($post['param'], " ");
		$panelid = explode(" ",$post['param']);
		$query = "";
		
		for($count = 0; $count < count($panelid); $count++)
		{
			$query= "INSERT INTO role_panel_mapping (roleid, panel_id) VALUES ('".$post['roleid']."', '".$panelid[$count]."') WHERE not exists (SELECT panel_id FROM role_panel_mapping WHERE role_panel_mapping.roleid ='".$post['roleid']."');";
			mysql_query($query);
		}
		return true;
	}
	return false;
}

public function deletethisrole($role)
{
	$dbHandle = $this->init();
	$query = "update roles set isactive='0' where rolename='".$role."';";
	$result = $dbHandle->query($query);
 	if($result)
 		return true;
 	else
 		return false;
}

public function updatePanel($panel_id, $post){
	$dbHandle = $this->init();
	error_log("post array is ".print_r($post,true));
	$query = "update panel_tbl set panel_name='".$post['panel_name']."', panel_parent_id='".$post['panel_parent']."', panel_desc='".$post['panel_desc']."', panel_status='".$post['panel_status']."' where panel_id='".$panel_id."'";
	error_log("update panel ".$query);
	$result = $dbHandle->query($query);
	if($result)
	{
		return true;
	}
	else
	{return false;
	}
}

public function insertUser($post,$passwd){
	$dbHandle = $this->init();
	$query = "insert into user_tbl(user_username, user_role_id, user_status,user_password) values('".$post['username']."', ".$post['user_role'].", '".$post['user_status']."','".$passwd."')";
	//error_log("insert user ".$query);
	$result = $dbHandle->query($query);
	if($result)
	{return true;}
	else
	{return false;}
}

public function insertRole($post){
	$dbHandle = $this->init();
	$query = "insert into role_tbl(role_name, role_desc, role_status) values('".strtoupper($post['role_name'])."', '".$post['role_desc']."', '".$post['role_status']."')";
	//error_log("insert user ".$query);
	$result = $dbHandle->query($query);
	if($result)
	{
		return true;
	}
	else
	{return false;
	}
}

public function insertPanel($post){
	$dbHandle = $this->init();
	$query = "insert into panel_tbl(panel_parent_id, panel_name, panel_url, panel_desc, panel_status, panel_type) values('".$post['panel_parent']."', '".$post['panel_name']."', '".$post['panel_url']."', '".$post['panel_desc']."', '".$post['panel_status']."', '".$post['panel_type']."')";
	//error_log("insert user ".$query);
	$result = $dbHandle->query($query);
	if($result)
	{
		return true;
	}
	else
	{
		return false;
	}
}
public function activeusers()
{
	$dbHandle = $this->init();
	$query = "SELECT * FROM users WHERE users.active = 1";
	$result = mysql_query($query);
	$userData=array();
	$i = 0;
	
	while($row = mysql_fetch_assoc($result))
		$userData[$i++] = $row;
	
	return $userData;
}

public function edituser()
{
	$dbHandle = $this->init();
	$query = "SELECT * FROM users WHERE users.active = 1";
	$result = mysql_query($query);
	$userData=array();
	$i = 0;
	
	while($row = mysql_fetch_assoc($result))
		$userData[$i++] = $row;
	
	return $userData;
}

public function editthisuser()
{
	$dbHandle = $this->init();
	$user_id = $_POST['username'];
	$query = "SELECT user_name, active, user_id, user_roleid FROM users WHERE users.user_emailid ='".$user_id."'";
	$result = mysql_query($query);	
}

public function updateuser($data)
{	
	$active = 0;
	if($data['active'] == 'yes')
		$active = 1;
	
	$dbHandle = $this->init();
	$query = "SELECT roleid FROM roles WHERE rolename='".$data['role']."'";
	$result = mysql_query($query);
	$roleid = mysql_fetch_assoc($result);
	//$query = "UPDATE users SET active=".$active.", user_name=".$data['username'].", user_roleid=".$roleid['roleid']." where user_id='".$data['userid']."'";
	$query1 = "UPDATE users SET active='".$active."' where user_id='".$data['userid']."'";
	$query2 = "UPDATE users SET user_name='".$data['username']."' where user_id='".$data['userid']."'";
	$query3 = "UPDATE users SET user_roleid='".$roleid['roleid']."' where user_id='".$data['userid']."'";
	
	$result1 = $dbHandle->query($query1);
	$result2 = $dbHandle->query($query2);
	$result3 = $dbHandle->query($query3);
	
	if($result1 && $result2 && $result3)
	{
		return true;
	}
	else
	{
		return false;
	}
}

public function getAllInformation($username)
{
	$row = array();
	
	$dbHandle = $this->init();
	$query = "SELECT user_id, active, user_roleid FROM users WHERE users.user_name ='".$username."'";
	$result = mysql_query($query);
	$row[0] = mysql_fetch_assoc($result);
	
	$query = "SELECT rolename FROM roles WHERE roles.roleid ='".$row[0]['user_roleid']."'";
	$result = mysql_query($query);
	$row[1] = mysql_fetch_assoc($result);
	
	return $row;
}

public function getAllRoleInformation($roleid)
{
	$row = array();
	$temp = array();
	$i = 0;
	
	$dbHandle = $this->init();
	$query = "SELECT roleid, rolename, role_description, isactive FROM roles WHERE roles.roleid ='".$roleid."'";
	$result = mysql_query($query);
	$row[0] = mysql_fetch_assoc($result);
	
	$query = "SELECT panel_id FROM role_panel_mapping WHERE role_panel_mapping.roleid ='".$roleid."'";
	$result = mysql_query($query);
	
	if($result && mysql_num_rows($result) > 0)
	{
		while($current = mysql_fetch_assoc($result))
		{
			$temp[$i]=$current;
			$i++;
		}
		$row[1] = $temp;
	}
	return $row;
}


public function deleteUser($user_id)
{
	$dbHandle = $this->init();
	$query = "update users set active='0' where user_email='".$user_id."'";
	$result = $dbHandle->query($query);
	
	if($result)
	{
		return true;
	}
	else
	{
		return false;
	}
}

public function updatePermissions($post){
	$dbHandle = $this->init();
	//error_log("post arrif(!isset($perms)) {
	$perms=$post['permission'];
	$perms=implode(",", $perms);
	//error_log("permissions ".print_r($perms, true));
	$query = "update ck_user_tbl set user_permissions='$perms' where user_id='".$post['username']."'";
	//error_log("query ".$query);
	$result = $dbHandle->query($query);
}
}//EOF