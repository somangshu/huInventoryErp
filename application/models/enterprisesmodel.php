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
    	if(mysql_num_rows($result) >0)
    	{
    		$row=mysql_fetch_assoc($result);
    		$userData=$row;
    	}
    	
    	return $userData;
    }

    public function getAllPanelsByRole($role_id)
    {
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
    	$panels = explode(', ', $data['panels']);

    	$dbHandle = $this->init();
    	
    	$query = "INSERT INTO roles(rolename, role_description, isactive) VALUES ('";
    	$query .= $data['rolename']."', '";
    	$query .= $data['roledesc']."', '";
    	$query .= $data['active']."');";
		$result = mysql_query($query);

		$query = "SELECT roleid FROM roles WHERE roles.rolename ='".$data['rolename']."'";
		$result = mysql_query($query);
		$roleid = mysql_fetch_assoc($result);

		for($i = 0; $i<count($panels); $i++ )
		{
			$query = "INSERT INTO role_panel_mapping(roleid, panel_id) VALUES ('";
			$query .= $roleid['roleid']."', '";
    		$query .= $panels[$i]."');";
    		echo $query;

    		$result = mysql_query($query);
		}
    	    	
    	return true;

    }

    public function updaterole($data)
    {	
    	$panels = $data['panels'];

    	$dbHandle = $this->init();

    	$query = "SELECT roleid FROM roles WHERE roles.rolename ='".$data['rolename']."'";
		$result = mysql_query($query);
		$roleid = mysql_fetch_array($result);
   
    	$query1 = "UPDATE roles SET rolename='".$data['rolename']."' where roleid='".$roleid['roleid']."'";
    	$result = mysql_query($query1);
		$query2 = "UPDATE roles SET role_description='".$data['roledesc']."' where roleid='".$roleid['roleid']."'";
		$result = mysql_query($query2);
		$query3 = "UPDATE roles SET isactive='".$data['active']."' where roleid='".$roleid['roleid']."'";
		$result = mysql_query($query3);

		for($i = 0; $i<count($panels); $i++ )
		{
			$query = "SELECT * FROM role_panel_mapping WHERE panel_id = ".$panels[$i]." AND roleid = ".$roleid['roleid'].";";
			$result = mysql_query($query);
			$bool = mysql_fetch_assoc($result);

			if($bool)
			{
				$query = "DELETE FROM role_panel_mapping WHERE panel_id = ".$panels[$i]." AND roleid = ".$roleid['roleid'];
				$result = mysql_query($query);
			}
			else
			{
				$query = "INSERT INTO role_panel_mapping (roleid, panel_id) VALUES (".$roleid['roleid'].",".$panels[$i].");";
				$result = mysql_query($query);
			}
		}
    	return true;
    }
    
    public function addpanel($data)
    {
    	$dbHandle = $this->init();

    	$query = "INSERT INTO panels(panel_name, panel_url, panel_description, panel_parent_id, panel_type) VALUES ('";
    	$query .= $data['panelname']."', '";
    	$query .= $data['panelurl']."', '";
    	$query .= $data['paneldesc']."', '";
    	$query .= $data['parent']."', '";
    	$query .= $data['type']."')";
    			
    	$result = mysql_query($query);

    	$query = "SELECT panel_id FROM panels WHERE panels.panel_name='".$data['panelname']."';";
    	$result = mysql_query($query);
    	$row = mysql_fetch_assoc($result);
    	$panelid = $row['panel_id'];

    	$query = "INSERT INTO role_panel_mapping(roleid, panel_id) VALUES ('";
    	$query .= '1'."', '";
    	$query .= $panelid."')";

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
	//error_log(print_r($usersArray));
	return $usersDetailsArray;
}

public function getAllRoles(){
	$dbHandle = $this->init();
	$query = "SELECT * FROM roles";
	//$query .= " where role_status='1'";
	//$query .= " order by roleid";
	
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

public function getAllPanels()
{
	$dbHandle = $this->init();
	$query = "SELECT * FROM panels;";

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

public function deletepanel($panel_id)
{
	$dbHandle = $this->init();
	$query = "DELETE FROM panels WHERE panel_id=".$panel_id;
	$result = $dbHandle->query($query);

	if($result)
	{
		$query = "DELETE FROM role_panel_mapping WHERE panel_id=".$panel_id;
		$result = $dbHandle->query($query);
		
		if($result)
			return true;
		else
			return false;
	}	
	else
		return false;
}

public function visiblepanels()
{
	$dbHandle = $this->init();
	$query = "SELECT * FROM panels where panel_type='display';";

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

public function hiddenpanels()
{
	$dbHandle = $this->init();
	$query = "SELECT * FROM panels where panel_type='hidden';";

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

public function activeroles()
{
	$roleData = array();

	$dbHandle = $this->init();
	$query = "SELECT * FROM roles WHERE roles.isactive = 1";
	$result = mysql_query($query);
	$userData=array();
	$i = 0;
	
	while($row = mysql_fetch_assoc($result))
		$roleData[$i++] = $row;
	
	return $roleData;
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

public function updatePermissions($post)
{
	$dbHandle = $this->init();
	//error_log("post arrif(!isset($perms)) {
	$perms=$post['permission'];
	$perms=implode(",", $perms);
	//error_log("permissions ".print_r($perms, true));
	$query = "update ck_user_tbl set user_permissions='$perms' where user_id='".$post['username']."'";
	//error_log("query ".$query);
	$result = $dbHandle->query($query);
}

public function getAllPanelInformation($panelid)
{
	$row = array();
	
	$dbHandle = $this->init();
	$query = "SELECT * FROM panels WHERE panels.panel_id ='".$panelid."'";
	$result = mysql_query($query);
	$row[0] = mysql_fetch_assoc($result);

	return $row;
}

public function updatepanel($data)
{	
	$dbHandle = $this->init();
	
	$query1 = "UPDATE panels SET panel_name='".$data['panelname']."' where panel_id='".$data['panelid']."'";
	$query2 = "UPDATE panels SET panel_description='".$data['paneldesc']."' where panel_id='".$data['panelid']."'";
	$query3 = "UPDATE panels SET panel_parent_id='".$data['parent']."' where panel_id='".$data['panelid']."'";
	$query4 = "UPDATE panels SET panel_type='".$data['panelname']."' where panel_id='".$data['type']."'";
	
	$result1 = $dbHandle->query($query1);
	$result2 = $dbHandle->query($query2);
	$result3 = $dbHandle->query($query3);
	$result4 = $dbHandle->query($query4);
	
	if($result1 && $result2 && $result3 && $result4)
	{
		return true;
	}
	else
	{
		return false;
	}
}

public function getAllRoleInformation($roleid)
{
	$row = array();
	$i = 0;
	
	$dbHandle = $this->init();
	$query = "SELECT rolename FROM roles WHERE roles.roleid ='".$roleid."'";
	$result = mysql_query($query);
	$rolename = mysql_fetch_assoc($result);

	$query = "SELECT * FROM roles WHERE roles.rolename ='".$rolename['rolename']."'";
	$result = mysql_query($query);
	$row[0] = mysql_fetch_assoc($result);

	$query = "SELECT roleid FROM roles WHERE roles.rolename ='".$rolename['rolename']."'";
	$result = mysql_query($query);
	$roleid = mysql_fetch_array($result);
	
	$query = "SELECT panel_id FROM role_panel_mapping WHERE role_panel_mapping.roleid ='".$roleid['roleid']."';";
	$result = mysql_query($query);
	while($current = mysql_fetch_assoc($result))
		$row[1][$i++] = $current['panel_id'];
	
	return $row;
}

public function deleterole($roleid)
{
	$dbHandle = $this->init();
	$query = "DELETE FROM roles WHERE roleid=".$roleid;
	$result = $dbHandle->query($query);

	if($result)
	{
		$query = "DELETE FROM role_panel_mapping WHERE roleid=".$roleid;
		$result = $dbHandle->query($query);
		
		if($result)
			return true;
		else
			return false;
	}	
	else
		return false;
}

	public function originalpanels($rolename)
	{

    	$dbHandle = $this->init();
    	
    	$query = "SELECT roleid FROM roles WHERE roles.rolename ='".$rolename."'";
		$result = mysql_query($query);
		$roleid = mysql_fetch_array($result);

    	$query = "SELECT panel_id FROM role_panel_mapping WHERE roleid='".$roleid['roleid']."'";
    	$result = mysql_query($query);	
    	$panelsArray = array();
    	
    	$i=0;
    	
    	while($row = mysql_fetch_assoc($result))
    	{
    		$panelsArray[$i] = $row['panel_id'];
    		$i++;
    	} 

    	return $panelsArray;
    }

    public function getAllImages()
    {
		$dbHandle = $this->init();
    	
    	$query = "SELECT imageurl, imageid FROM insta_images WHERE 1 ORDER BY imageid DESC";
		$result = mysql_query($query);
		
		$imageurls = array();
		$i = 0;

		while($row = mysql_fetch_assoc($result))
    	{
    		$imageurls[$i] = $row['imageurl'];
    		$i++;
    	}
    	return $imageurls;
    }

    public function insertnexturl($id)
    {
    	$dbHandle = $this->init();
    	
    	$query = "UPDATE lastimage SET nextimage=".$id." WHERE which='this';";
    	$result = mysql_query($query);
    }

    public function getnexturl()
    {
    	$dbHandle = $this->init();
    	
    	//$query = "SELECT MAX(imageid) as maxid FROM insta_images";
		$query = "SELECT nextimage FROM lastimage WHERE which='this'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);

		var_dump($row["nextimage"]);

		return $row["nextimage"];
    }

    public function getimageids()
    {
		$dbHandle = $this->init();
    	
		$imageids = array();
		$i = 0;

		$query = "SELECT imageid FROM insta_images WHERE 1";
		$result = mysql_query($query);
		
		while($row = mysql_fetch_assoc($result))
    	{
    		$imageids[$i] = $row['imageid'];
    		$i++;
    	}
    	return $imageids;
    }

    public function getSearchImages($post, $page)
    {
    	$start_from = ($page-1) * 20; 
    	$i = 0;

    	$data = array();
    	$imageurl = array();

    	$dbHandle = $this->init();

    	$tag = $post['tag'];
		$source = $post['source'];
		$date = $post['date'];

		$query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT insta_images.imageurl, insta_images.imageid FROM insta_images, tags WHERE insta_images.imageid = tags.imageid AND ";
   		if($tag != '')
   			$query .= "tags.tag = '".$tag."' AND ";
   		if($source != 'None')
   			$query .= "insta_images.source = '".$source."' AND ";
   		if($date != '')
   			$query .= "DATE(insta_images.createdat) = '".$date."' AND ";
   		
   		$sub = substr($query, 0, strlen($query)-5);
		$sub .= "ORDER BY imageid DESC LIMIT ".$start_from.", 20;";

    	$result = mysql_query($sub);

		while($row = mysql_fetch_assoc($result))
    	{
    		$image = $row['imageurl'];
    		$imageurl[$i] = '<a href="/imageinfo/'.$row['imageid'].'"><img src="'.$image.'" alt="WTF" style="width:320px;height:320px"></a>';
    		$i++;
    	}
    	$data['url'] = $imageurl;
    	
    	
    	if($result)
    	{
            $queryCnt  = "SELECT FOUND_ROWS() as order_cnt";
            $resultCntQuery = mysql_query($queryCnt) or die(mysql_error());
            $row1 = mysql_fetch_assoc($resultCntQuery);
            
            if(isset($row1['order_cnt']) && $row1['order_cnt']!='') 
                $total_records= $row1['order_cnt'];
		} 
    	$total_pages = ceil($total_records / 20); 
    	
		$data['totalpages'] = $total_pages;    

    	return $data;
    }

    public function pagination($page)
    {
    	$data = array();
    	$i = 0;
    	$dbHandle = $this->init();

    	$start_from = ($page-1) * 20; 

    	$query = "SELECT imageurl, imageid FROM insta_images ORDER BY imageid DESC LIMIT ".$start_from.", 20"; 
    	$result = mysql_query ($query); 
    	
		$imageurl = array();

    	while ($row = mysql_fetch_assoc($result))
    	{
    		$image = $row['imageurl'];
			$imageurl[$i++] =  '<a href="/imageinfo/'.$row['imageid'].'"><img src="'.$image.'" alt="WTF" style="width:320px;height:320px"></a>';
		}
		$data['url'] = $imageurl;

    	$query = "SELECT COUNT(imageid) FROM insta_images"; 
    	$result = mysql_query($query); 
    	$row = mysql_fetch_row($result); 
    	
    	$total_records = $row[0]; 
    	$total_pages = ceil($total_records / 20); 
    	
		$data['totalpages'] = $total_pages;    

    	return $data;
    }

    public function getImageInfo($id)
    {
    	$dbHandle = $this->init();
    	
    	$tags = array();
    	$i = 0;

		$query = "SELECT * FROM insta_images WHERE imageid='".$id."'";
		$result = mysql_query($query);
		$row[0] = mysql_fetch_assoc($result);

		$query = "SELECT status FROM statustable WHERE imageid='".$id."'";
		$result = mysql_query($query);
		$row[1] = mysql_fetch_assoc($result);

		$query = "SELECT * FROM manualcategorytags WHERE imageid='".$id."'";
		$result = mysql_query($query);
		while ($temp = mysql_fetch_assoc($result))
    		$tags[$i++] = $temp['tag'];
		$row[2] = $tags;

		$i = 0;

		$query = "SELECT * FROM consumertype WHERE imageid='".$id."'";
		$result = mysql_query($query);
		$row[3] = mysql_fetch_assoc($result);

		$query = "SELECT * FROM tags WHERE imageid='".$id."'";
		$result = mysql_query($query);
		while ($temp = mysql_fetch_assoc($result))
    		$tags[$i++] = $temp['tag'];
		$row[4] = $tags;		

		return $row;
    }

    public function insertstatus($imageid)
    {
    	$dbHandle = $this->init();

    	$i=0;
    	$imageid = array();
    	$query = "SELECT imageid FROM insta_images WHERE 1";//change condition -> OR -> just insert
    	$result = mysql_query($query);

		while($row = mysql_fetch_assoc($result))
    		$imageid[$i++] = $row['imageid'];
    	
    	foreach($imageid as $image)
    	{
    		$query = "INSERT INTO statustable (imageid, status) VALUES (".$image." ,'active')";
    		echo $query;
    		$result = mysql_query($query);
    		echo $result;
    	} 
    }
}//EOF