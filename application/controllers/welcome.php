<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		date_default_timezone_set('Asia/Calcutta');
		$this->load->library('session');
		$this->load->model('enterprisesmodel');
		$sessionUserData = $this->session->all_userdata();
		$displayData['sessionUserData']=$sessionUserData;
		
		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']==true)
		{
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$notDisplayArray[0] = 0;
			$displayData['notDisplay']=$notDisplayArray;
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('welcomepage.php',$displayData);;
		}
		else
		{
			$random=random_string('alnum',10);
			$this->session->set_userdata(array('randomNumber'=>$random));
			$displayData['random'] = $random;
			$this->load->view('login/login', $displayData);
		}
	}
			
   public function validateLogin()
   {
   		$this->load->model('enterprisesmodel');
   		$this->load->library('session');
    
   		$sessionUserData = $this->session->all_userdata();
   		
   		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
   		{
   			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_roleid']);
   			$displayData['sessionUserData']=$sessionUserData;
   			$this->load->view('welcomepage', $displayData);
   		}
   		else
   		{
   			$userData=$this->enterprisesmodel->doValidateLogin(strtolower($_POST['username']),$_POST['password']);
	   		
	   		if (!empty($userData))
	   		{
	   		   	$sessionUserDataToSet = array(
	   				'user_id'  => $userData['user_id'],
	   		   		'user_name'  => $userData['user_name'],
	   				'user_email'  => $userData['user_email'],
	   				'user_role_id'  => $userData['user_roleid'],
	   				'logged_in' => TRUE
	   			);
	   			$this->session->set_userdata($sessionUserDataToSet);
	   	 	}
	   	 	else
	   	 	{
	   			$array_items = array('user_id' => '', 'username' => '', 'user_permissions' => '', 'logged_in' => '');
	   			$this->session->unset_userdata($array_items);
	   		}
	   		$sessionUserData = $this->session->all_userdata();
	   		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	   		{
	   			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
	   			$displayData['sessionUserData']=$sessionUserData;
	   			$this->load->view('welcomepage', $displayData);
	   		}
	   		else
	   		{
	   			$message="Authentication Failure !";
	   			$displayData['message']=$message;
	   			$this->load->view('login', $displayData);
	   		}
   		}  	
   	}
 
	public function action()
	{
		$this->load->model('enterprisemodel.php');
		$this->load->view('welcome_message.php');
		$result=$this->enterprisemodel->actionDB($a,$b);
		$displayData['result']=$result;
		$this->load->view('welcome_message.php',$displayData);
	}
	
	public function addpanel()
	{
		$data = array('content'=>'addpanel');
		$this->load->view('/common/viewtemplate',$data);
	}
	
	public function addeduser()
	{	
		$this->load->model("enterprisesmodel");
		$list = '';
		
		$data['username'] = $_POST['username'];
		$data['password'] = $_POST['password'];
		$data['name'] = $_POST['name'];
		$data['date'] = date('d-m-Y');
		$data['role'] = $_POST['role'];
		
		if( isset($_POST['checklist']) && is_array($_POST['checklist'])) 
		{
    		foreach($_POST['checklist'] as $checklist) 
    		{
				$list .= $checklist.", ";		
    		}
    		$sub = strrchr($list, ", \"");
    		$list = trim($list, $sub);
    	}
    	
    	$data['list'] = $list;
    	
    	
		$this->enterprisesmodel->addUser($data);
	}
	
	public function addedrole()
	{
		$data['rolename'] = $_POST['rolename'];
		$data['roledesc'] = $_POST['roledesc'];
		$data['isactive'] = $_POST['isactive'];
		$data['param'] = $_POST['param'];
		
		$this->load->model('enterprisesmodel');
		$this->load->library('session');
		
		$sessionUserData = $this->session->all_userdata();
		
		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
		{
			$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
			$displayData['results'] = $this->enterprisesmodel->activeusers();
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['roleid'] = $this->enterprisesmodel->addrole($data);
			$displayData['sessionUserData']=$sessionUserData;
			
			//$this->load->view('edituser', $displayData);
		}
		else
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
	}
	
	public function addedpanel()
	{
		$this->load->model('enterprisemodel');
		
		$data['panelname'] = $_POST['panelname'];
		$data['paneldesc'] = $_POST['paneldesc'];
		$data['panelurl'] = $_POST['panelurl'];
		$data['paneltype'] = $_POST['active'];
		$data['panelparent'] = $_POST['panelparent'];
		
		$this->enterprisemodel->addpanel($data);
	}
	
	public function userslink()
	{
		$data['content']='userslink';
		$this->load->view('/common/viewtemplate',$data);
	}
	
	public function roleslink()
	{
		$data['content']='roleslink';
		$this->load->view('/common/viewtemplate',$data);
	}
	
	public function panelslink()
	{
		$data['content']='panelslink';
		$this->load->view('/common/viewtemplate',$data);
	}


public function resetPassword()
{
	$this->load->library('session');
	$this->load->model('enterprisesmodel');
	$sessionUserData = $this->session->all_userdata();
	$displayData['sessionUserData']=$sessionUserData;
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']==true)
	{
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$this->load->view('welcome', $displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('resetPassword', $displayData);
	}
}

public function changePassword()
{
	$this->load->library('session');
	$this->load->model('enterprisesmodel');
	$sessionUserData = $this->session->all_userdata();
	$displayData['sessionUserData']=$sessionUserData;
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']==true)
	{
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$this->load->view('changePassword', $displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function updateNewPassword()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$displayData['messageU']='';
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$_POST['username']=$sessionUserData['username'];
		$insertResult=$this->enterprisesmodel->updateNewPassword($_POST);
		
		if($insertResult)
		{
			$displayData['message']="Password changed successfully!";
		}
		else
		{
			$displayData['message']="Password Updation failed.";
		}
		
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('changePassword', $displayData);
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function gAuthenticate($random,$phone=0)
{
	$this->load->library('session');
	$this->load->model('enterprisesmodel');
	$personMarkup = "$email";
	// The access token may have been updated lazily. */
	$email = file_get_contents("http://".ipEmail.":90?random=".$random);
	 
	error_log("email id is ".print_r($email, true));
	
	if (!empty($email))
	{
		$username=$this->enterprisesmodel->getUserDetailsByEmail($email);
		if (!empty($username))
		{
			$multiOrderSearchUser=$this->enterprisesmodel->getAccessRole("multi_order_search",$username[0]['user_role_id']);
			$newdata = array(
					'user_id'  => $username[0]['user_id'],
					'username'  => $username[0]['user_username'],
					'user_role_id'  => $username[0]['user_role_id'],
					'multi_order_search'=> $multiOrderSearchUser,
					'logged_in'=> true
					);
			$this->session->set_userdata($newdata);
			$sessionUserData = $this->session->all_userdata();
			error_log("sessionUserData is ".print_r($sessionUserData, true));
			
			if (isset($sessionUserData['token'])) 
			{
				$client->setAccessToken($sessionUserData['token']);
			}
			if($phone!=0)
			{
				$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
				$displayData['sessionUserData']=$sessionUserData;
				$this->czentrixCall($phone);
			}
			else
			{
				$notDisplayArray[0] = 0;
				$displayData['notDisplay']=$notDisplayArray;
				$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
				$displayData['sessionUserData']=$sessionUserData;
				$this->load->view('sales/viewOrders', $displayData);
			}
		}
		else
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$message="This Email Id does not linked to any Valyoo Users.";
			$displayData['message']=$message;
			$this->load->view('login', $displayData);
		}
	} 
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$message="Authentication Failure !";
		$displayData['message']=$message;
		$this->load->view('login', $displayData);
	}
}


public function logOut()
{
	$this->load->library('session');
	$pTabSelection="";
	$array_items = array('user_id'  => '', 'user_name' => '', 'token' => '', 'user_role_id'  => '', 'logged_in'=> '');
	
	$this->session->unset_userdata($array_items);
	
	$displayData['message']="Logged Out Successfully !";
	
	if($_SERVER['HTTP_HOST']=='hu')
	{
		header('Location: http://hu/');
	}
	else
	{
		header('Location: '.WEBSITE_ROOT."?gc=1");
	}
}

public function authenticate()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	
	if(isset($_POST['selDept']) && $_POST['username']!="" && $_POST['password']!="" && $_POST['selDept']!="")
	{
		$this->enterprisesmodel->fillDepartment($_POST);
	}
	$username=$this->enterprisesmodel->authenticate($_POST);
	
	if (isset($username[0]['user_username']) && !strcasecmp($_POST['username'],$username[0]['user_username']))
	{
		$multiOrderSearchUser=$this->enterprisesmodel->getAccessRole("multi_order_search",$username[0]['user_role_id']);
		$newdata = array(
				'user_id'  => $username[0]['user_id'],
				'username'  => $username[0]['user_username'],
				'user_role_id'  => $username[0]['user_role_id'],
				'multi_order_search'=> $multiOrderSearchUser,
				'logged_in' => TRUE
				);
		$this->session->set_userdata($newdata);
		$sessionUserData = $this->session->all_userdata();
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
	}
	else
	{
		$array_items = array('user_id' => '', 'username' => '', 'user_permissions' => '', 'logged_in' => '');
		$this->session->unset_userdata($array_items);
	}
	
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('welcome', $displayData);
	}
	else 
	{
		$message="Authentication Failure !";
		$displayData['message']=$message;
		$this->load->view('login', $displayData);
	}
}

public function checkDepartment()
{
	$this->load->model('enterprisesmodel');
	if(isset($_POST['userId']) && isset($_POST['passwd']))
	{
		$userId = $_POST['userId'];
		$passwd = $_POST['passwd'];
		$result = $this->enterprisesmodel->checkDepartment($userId,$passwd);
		$dept=array();
		$departments = $this->enterprisesmodel->fetchDepartment();
		
		if(!empty($departments))
		{
			$dept['dept']= json_encode($departments);
			$dept['result']= $result;
		}
		echo json_encode($dept);
	}
}

public function updatePassword()
{
	$this->load->model('enterprisesmodel');
	$username=$this->enterprisesmodel->updatePassword($_POST);
	$toName = '' ;
	
	if (isset($username[0]['user_password']))
	{
		$username[0]['user_password']=base64_decode($username[0]['user_password']);
		if (strpos($username[0]['user_username'], '@dealskart') !== false) 
		{
			$toName=ucfirst(substr($username[0]['user_username'], 0, strpos($username[0]['user_username'], '.')-1));
		}          
		elseif(strpos($username[0]['user_username'], '@valyoo') !== false)
		{
			$toName=ucfirst(substr($username[0]['user_username'], 0, strpos($username[0]['user_username'], '@')-1));
		}
		
		elseif(strpos($username[0]['user_username'], '@ienergizer') !== false){
			$toName=ucfirst(substr($username[0]['user_username'], 0, strpos($username[0]['user_username'], '@')-1));
		}
		
		elseif(strpos($username[0]['user_username'], '@lenskart') !== false)
		{
			$toName=ucfirst(substr($username[0]['user_username'], 0, strpos($username[0]['user_username'], '@')-1));
		}
		
		$bdy = '<html><head></head><body><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tbody><tr>
                        <td>
      
                        <table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                        </tr>
                        <tr style="padding: 16px 0px 16px 16px"><td bgcolor="#fff" colspan="2" style="padding: 16px;  "> <font face="Segoe UI,helvetica" color="#666"> Dear '.$toName.',<br><br>
                        Greetings for the Day!<br /><br />
                        With reference to your request for Forgot Password, your current password is "'.$username[0]['user_password'].'".
			VSM Link:- <a href="http://vsm.lenskart.com" target="_blank">VSM Homepage</a>
                        Please login using your current email id and given password again. If you still face any issue, Please contact Techops Team @ techops@valyoo.in.
                        <br /<br />
                        <br>
                        Happy to Help You!
                        <br><br>
                        Thanks & Regards
                        <br>
                        Techops Team
<br><br>
                        </tbody></table>
      
                        </td>
                        </tr>
                        </tbody></table></body></html>';
		$fromEmail='techops@valyoo.in';
		$fromName='Techops Team';
		$toEmail=$username[0]['user_username'];
		$subject="Forgot Password";
		$body=$bdy;
		$path='none';
		$status=$this->enterprisesmodel->insertEmail($fromEmail, $fromName, $toEmail, $toName, $subject, $body,$path);
		if($status==1){
			echo "Password sent to ".$username[0]['user_username'];
		}
	}else{
		echo "Email Id does not exists !";
	}
}

/**
 * Find position of Nth $occurrence of $my_char in $url
 * Starts from the beginning of the string
 **/
public function strpos_offset($my_char, $url, $occurrence) {
	// explode the $url
	$arr = explode($my_char, $url);
	// check the $my_char is not out of bounds
	switch( $occurrence ) {
		case $occurrence == 0:
			return false;
		case $occurrence > max(array_keys($arr)):
			return false;
		default:
			return strlen(implode($my_char, array_slice($arr, 0, $occurrence)));
	}
}

public function my_url(){

	$url = (!empty($_SERVER['HTTPS'])) ? "https://".SERVER_NAME.$_SERVER['REQUEST_URI'] : "http://".SERVER_NAME.$_SERVER['REQUEST_URI'];

	$start_pos = $this->strpos_offset('/', $url, 3);
	$end_pos = $this->strpos_offset('/', $url, 4);
	if ($end_pos) {
		$url = substr($url,$start_pos,$end_pos-$start_pos);
	}
	else {
		$url = substr($url,$start_pos);
	}
	return $url;

}

public function accessManagement($role_id=17)
{
	$this->load->library('session');
	$this->load->model('enterprisesmodel');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray))
		{
			$menuPanelsArray=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['menuPanelsArray']=$menuPanelsArray;
			$displayData['sessionUserData']=$sessionUserData;
			$displayData['role_id']=$role_id;
			$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($role_id);
			$displayData['rolePanelArray']=$rolePanelArray;
			$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('Yes');
			$displayData['mainPanelsArray']=$this->enterprisesmodel->getMainPanels('Yes');
			$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
			$this->load->view('accessManagement', $displayData);
		}
		else 
		{
			header('Location: '.WEBSITE_ROOT);
		}
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function accessManagementByAjax($role_id)
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['role_id']=$role_id;
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('Yes');
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['rolePanelArray']=$this->enterprisesmodel->getPanelsByRole($role_id);
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('common/accessManagementAjax', $displayData);
	}
	else 
	{
		header('Location: '.WEBSITE_ROOT);
	}
}

public function insertRolePanelMapping()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'] && isset($_POST['role_id']))
	{
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$role_id=$_POST['role_id'];
		$displayData['role_id']=$role_id;
		$displayData['message']="You have successfully edited Panel Access";
		$this->enterprisesmodel->insertRolePanelMapping($_POST);
		$displayData['rolePanelArray']=$this->enterprisesmodel->getPanelsByRole($role_id);
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('Yes');
		$displayData['mainPanelsArray']=$this->enterprisesmodel->getMainPanels('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('accessManagement', $displayData);
	}
	else 
	{
		header('Location: '.WEBSITE_ROOT);
	}
}

public function adduser()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
		$displayData['rolesArray']=$this->enterprisesmodel->getAllRoles();
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		
		$this->load->view('/user/adduser', $displayData);
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function viewdelete()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	
	$sessionUserData = $this->session->all_userdata();
	
	$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
	$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
	$displayData['sessionUserData']=$sessionUserData;
	
	$this->load->view('/user/deleteuser', $displayData);
}

public function activeuser()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
		$displayData['results'] = $this->enterprisesmodel->activeusers();
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		
		$this->load->view('/user/activeusers', $displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}


public function deleteuser()
{
	$user_id = $_POST['username'];
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
		$deleteResult = $this->enterprisesmodel->deleteUser($user_id);
		if($deleteResult)
		{
			echo "User successfully Deleted!";
		}
		else
		{
			echo "User Deletion failed.";
		}
		//CHECK IF THIS WILL BE NEEDED
		//$displayData['allUsersArray']=$this->enterprisesmodel->getAllUsers('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		//$this->load->view('user/viewUsers', $displayData);

	}
	else 
	{
		echo "in else";
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function insertUser()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$isUserExist = $this->enterprisesmodel->checkUserName($_POST['username']);
		if ($isUserExist=='Yes'){
			$displayData['messageU']="User Id already exist!";
		}
		else {
			$randPass='';
			$pass=mt_rand(10000,100000);
			$randPass=base64_encode($pass);
			$insertResult=$this->enterprisesmodel->insertUser($_POST,$randPass);
			if($insertResult){
				$toName='';
				if (strpos($_POST['username'], '@dealskart') !== false) {
					$toName=ucfirst(substr($_POST['username'], 0, strpos($_POST['username'], '.')-1));
				}elseif(strpos($_POST['username'], '@valyoo') !== false){
					$toName=ucfirst(substr($_POST['username'], 0, strpos($_POST['username'], '@')-1));
				}
				$bdy = '<html><head></head><body><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" >
					<tbody><tr>
					<td>

					<table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
					<tbody><tr>
					</tr>
					<tr style="padding: 16px 0px 16px 16px"><td bgcolor="#fff" colspan="2" style="padding: 16px;  "> <font face="Segoe UI,helvetica" color="#666"> Dear '.$toName.',<br><br>
					Thanks for registering with VSM!<br /><br />
					Your password is "'.$pass.'".<br>
					VSM Link:- <a href="http://vsm.lenskart.com" target="_blank">VSM Homepage</a>
					Please login using your current email id and given password. If you still face any issue, Please contact Techops Team @ techops@valyoo.in.
					<br /<br />
					<br>
					Happy to Help You!
					<br><br>
					Thanks & Regards
					<br>
					Techops Team
					<br><br>
					</tbody></table>

					</td>
					</tr>
					</tbody></table></body></html>';
				$fromEmail='techops@valyoo.in';
				$fromName='Techops Team';
				$toEmail=$_POST['username'];
				$subject="VSM Password";
				$body=$bdy;
				$path='none';
				$status=$this->enterprisesmodel->insertEmail($fromEmail, $fromName, $toEmail, $toName, $subject, $body,$path);
				if($status==1){
					$displayData['message']="User successfully created!<br>Password is sent to ".$_POST['username'];
				}
			}else{
				$displayData['message']="User Creation failed.";
			}
		}
		$displayData['allUsersArray']=$this->enterprisesmodel->getAllUsers('Yes');
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('user/createNewUser', $displayData);

	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function edituser()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
		$displayData['results'] = $this->enterprisesmodel->activeusers();
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		
		$this->load->view('/user/edituser', $displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function editthisuser()
{	
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$username = $_POST['username'];
		
		$displayData['panelsArray'] = $this->enterprisesmodel->getAllPanels();
		$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
		$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData'] = $sessionUserData;
		$displayData['allInformation'] = $this->enterprisesmodel->getAllInformation($username);
		$displayData['username'] = $username;
		
		$this->load->view('user/editthisuser', $displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function updateuser()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	$sendData = array();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$sendData['userid'] = $_POST['userid'];
		$sendData['username'] = $_POST['name'];
		$sendData['active'] = $_POST['active'];
		$sendData['role'] = $_POST['role'];

		$update = $this->enterprisesmodel->updateuser($sendData);
		
		if($update)
		{
			$displayData['panelsArray'] = $this->enterprisesmodel->getAllPanels();
			$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
			$displayData['results'] = $this->enterprisesmodel->activeusers();
			$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData'] = $sessionUserData;
		
			$this->load->view('/user/edituser', $displayData);
		}
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function addrole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['panelsArray'] = $this->enterprisesmodel->getAllPanels();
		$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
		$displayData['sessionUserData']=$sessionUserData;
		$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		
		$this->load->view('roles/addrole', $displayData);
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function editrole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['panelsArray'] = $this->enterprisesmodel->getAllPanels();
		$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
		$displayData['sessionUserData']=$sessionUserData;
		$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
	
		$this->load->view('roles/editrole', $displayData);
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function editthisrole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$roleid = $_POST['role'];
		
		$displayData['panelsArray'] = $this->enterprisesmodel->getAllPanels();
		$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
		$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData'] = $sessionUserData;
		$displayData['allInformation'] = $this->enterprisesmodel->getAllRoleInformation($roleid);
		$displayData['roleid'] = $roleid;
		
		$this->load->view('roles/editthisrole', $displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function updaterole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();

	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{	
		$displayData['roleid'] = $_POST['roleid'];
		$displayData['rolename'] = $_POST['rolename'];
		$displayData['roledesc'] = $_POST['roledesc'];
		$displayData['active'] = $_POST['active'];
		$displayData['param'] = $_POST['param'];
		
		$this->enterprisesmodel->updaterole($displayData);
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function deleterole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
		$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
	
		$this->load->view('roles/deleterole', $displayData);
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function deletethisrole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	
	$sessionUserData = $this->session->all_userdata();

	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$rolename = $_POST['rolename'];
		$result = $this->enterprisesmodel->deletethisrole($rolename);
		if(!$result)
			echo 'Role name does not exist';
		else 
			echo 'The role is no longer active.';
	}
	else
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function insertRole(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$isRoleExist = $this->enterprisesmodel->checkRoleName($_POST['role_name']);
		if ($isRoleExist=='Yes'){
			$displayData['messageU']="Role already exist!";
		}
		else {
			$insertResult=$this->enterprisesmodel->insertRole($_POST);
			if($insertResult){
				$displayData['message']="Role successfully Created!";
			}else{
				$displayData['message']="Role creation failed.";
			}
		}
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('role/createNewRole', $displayData);

	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function addPanelCS(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['mainPanelsArray']=$this->enterprisesmodel->getMainPanels('Yes');
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('panel/createNewPanel', $displayData);
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function editPanel($panel_id){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['mainPanelsArray']=$this->enterprisesmodel->getMainPanels('Yes');
		$displayData['panelDetailsArray']=$this->enterprisesmodel->getPanelDetails($panel_id);
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('panel/editPanel', $displayData);
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function deletePanel($panel_id){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$deleteResult=$this->enterprisesmodel->deletePanel($panel_id);
		if($deleteResult){
			$displayData['messageD']="Panel successfully deleted!";
		}else{
			$displayData['messageD']="Panel deletion failed.";
		}
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('panel/viewPanels', $displayData);
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function updatePanel($panel_id){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$insertResult=$this->enterprisesmodel->updatePanel($panel_id, $_POST);
		if($insertResult){
			$displayData['messageU']="Panel successfully updated!";
		}else{
			$displayData['messageU']="Panel updation failed.";
		}
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('panel/viewPanels', $displayData);
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function insertPanel(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){

		$displayData['mainPanelsArray']=$this->enterprisesmodel->getMainPanels('Yes');
		$isPanelExist = $this->enterprisesmodel->checkPanelName($_POST['panel_name']);
		if ($isPanelExist=='Yes'){
			$displayData['messageU']="Panel already exist!";
		}
		else {
			$insertResult=$this->enterprisesmodel->insertPanel($_POST);
			if($insertResult){
				$displayData['message']="Panel successfully created!";
			}else{
				$displayData['message']="Panel creation failed.";
			}
		}
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
		$this->load->view('panel/createNewPanel', $displayData);

	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewUsers(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['allUsersArray']=$this->enterprisesmodel->getAllUsers('0');
		$displayData['checkUserArray'] = '1';
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('user/viewUsers', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewRoles(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('0');
		$displayData['checkRoleArray'] = '1';
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('role/viewRoles', $displayData);
		}else {

			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewPanels(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('0');
		$displayData['checkPanelArray'] = '1';
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('panel/viewPanels', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewActiveRoles(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('Yes');
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('role/viewRoles', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewActivePanels(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('panel/viewPanels', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewDeletedUsers(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$currURL=$this->my_url();
		//error_log("current url is ".$currURL);
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		//error_log("role details array is".print_r($rolePanelArray, true));
		//error_log("panel_id is ".$panelDetailsArray[0]['panel_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
			$displayData['allUsersArray']=$this->enterprisesmodel->getAllUsers('No');
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('user/viewDeletedUsers', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewDeletedRoles(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('Yes');
		$displayData['allRolesArray']=$this->enterprisesmodel->getAllRoles('No');
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['sessionUserData']=$sessionUserData;
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$this->load->view('role/viewDeletedRoles', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function  viewDeletedPanels(){
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in']){
		$displayData['allPanelsArray']=$this->enterprisesmodel->getAllPanels('No');
		$currURL=$this->my_url();
		$panelDetailsArray=$this->enterprisesmodel->getPanelDetailsByUrl($currURL);
		$rolePanelArray=$this->enterprisesmodel->getPanelsByRole($sessionUserData['user_role_id']);
		if (in_array($panelDetailsArray[0]['panel_id'], $rolePanelArray)){
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			$this->load->view('panel/viewDeletedPanels', $displayData);
		}else {
			header('Location: '.WEBSITE_ROOT);
		}
	}else {
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

}
//changes

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */