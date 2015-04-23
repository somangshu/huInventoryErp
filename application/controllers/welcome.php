<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller 
{

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
   			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
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
	
	public function addpanel()
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
		
			$this->load->view('/panel/addpanel', $displayData);
		}
		else 
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
	}

	public function deletepanel()
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
		
			$this->load->view('/panel/deletepanel', $displayData);
		}
		else 
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
	}

	public function deletedpanel()
	{
		$this->load->model('enterprisesmodel');
		$this->enterprisesmodel->deletepanel($_POST['panel']);
	}

	public function editpanel()
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
		
			$this->load->view('/panel/editpanel', $displayData);
		}
		else 
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
	}

	public function editthispanel()
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
			$displayData['panelInfo'] = $this->enterprisesmodel->getAllPanelInformation($_POST['panelid']);

			$this->load->view('/panel/editthispanel', $displayData);
		}
		else 
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
	}

	public function updatepanel()
	{
		$this->load->model('enterprisesmodel');
		$this->load->library('session');
		$sessionUserData = $this->session->all_userdata();
		$sendData = array();
		
		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
		{
			$sendData['panelid'] = $_POST['panelid'];
			$sendData['panelname'] = $_POST['panelname'];
			$sendData['panelurl'] = $_POST['panelurl'];
			$sendData['paneldesc'] = $_POST['paneldesc'];
			$sendData['type'] = $_POST['type'];
			$sendData['parent'] = $_POST['parent'];

			$update = $this->enterprisesmodel->updatepanel($sendData);
			
			if($update)
			{
				$displayData['panelsArray'] = $this->enterprisesmodel->getAllPanels();
				$displayData['rolesArray'] = $this->enterprisesmodel->getAllRoles();
				$displayData['results'] = $this->enterprisesmodel->activeusers();
				$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
				$displayData['sessionUserData'] = $sessionUserData;
			
				$this->load->view('edituser', $displayData);
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

	public function visiblepanels()
	{
		$this->load->model('enterprisesmodel');
		$this->load->library('session');
		$sessionUserData = $this->session->all_userdata();
		
		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
		{
			$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
			$displayData['results'] = $this->enterprisesmodel->visiblepanels();
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			
			$this->load->view('/panel/visiblepanels', $displayData);
		}
		else
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
	}

	public function hiddenpanels()
	{
		$this->load->model('enterprisesmodel');
		$this->load->library('session');
		$sessionUserData = $this->session->all_userdata();
		
		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
		{
			$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
			$displayData['results'] = $this->enterprisesmodel->hiddenpanels();
			$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			$displayData['sessionUserData']=$sessionUserData;
			
			$this->load->view('/panel/hiddenpanels', $displayData);
		}
		else
		{
			$random=random_string('alnum',10);
			$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
			$displayData['random'] = $random;
			$this->load->view('login', $displayData);
		}
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
		$data['active'] = $_POST['active'];
		$data['panels'] = $_POST['panels'];
		
		$this->load->model('enterprisesmodel');
		$this->load->library('session');
		$sessionUserData = $this->session->all_userdata();
		
		if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
		{
			//$displayData['panelsArray']=$this->enterprisesmodel->getAllPanels();
			//$displayData['results'] = $this->enterprisesmodel->activeusers();
			$result = $this->enterprisesmodel->addrole($data);
			
			if($result)
			{
				echo $result;
				$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
				$displayData['sessionUserData']=$sessionUserData;
			
				$this->load->view('welcomepage', $displayData);
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
	
	public function addedpanel()
	{
		$this->load->model('enterprisesmodel');

		$data['panelname'] = $_POST['panelname'];
		$data['paneldesc'] = $_POST['paneldesc'];
		$data['panelurl'] = $_POST['panelurl'];
		$data['type'] = $_POST['type'];
		$data['parent'] = $_POST['parent'];

		$this->enterprisesmodel->addpanel($data);
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
		
		$this->load->view('adduser', $displayData);
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
	
	$this->load->view('deleteuser', $displayData);
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
		
		$this->load->view('activeusers', $displayData);
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
		
		$this->load->view('edituser', $displayData);
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
		
			$this->load->view('edituser', $displayData);
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
		$displayData['results'] = $this->enterprisesmodel->activeroles();
		$displayData['menuPanelsArray'] = $this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData'] = $sessionUserData;
		$displayData['flag'] = 0;

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

public function editthisrole()
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
		$displayData['roleInfo'] = $this->enterprisesmodel->getAllRoleInformation($_POST['role']);
		$displayData['flag'] = 1;
		$this->load->view('/roles/editthisrole', $displayData);
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
	$data['rolename'] = $_POST['rolename'];
	$data['roledesc'] = $_POST['roledesc'];
	$data['active'] = $_POST['active'];

	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		$original =$this->enterprisesmodel->originalpanels($data['rolename']);
		$modified = explode(', ', $_POST['panels']);
		$result1 = array_diff($modified, $original);
		$result2 = array_diff($original, $modified);
		$data['panels'] = array_merge($result1, $result2);
		
		$result = $this->enterprisesmodel->updaterole($data);
		
		if($result)
		{
			echo("1");
			//$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
			// $displayData['sessionUserData']=$sessionUserData;
			
			//$this->load->view('roles/editrole', $displayData);

		}
		else
		{
			echo("0");
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

public function deleterole()
{
	$this->load->model('enterprisesmodel');
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	
	if(isset($sessionUserData['logged_in']) && $sessionUserData['logged_in'])
	{
		
		$displayData['rolesArray']=$this->enterprisesmodel->getAllRoles();
		$displayData['menuPanelsArray']=$this->enterprisesmodel->getAllPanelsByRole($sessionUserData['user_role_id']);
		$displayData['sessionUserData']=$sessionUserData;
	
		$this->load->view('/roles/deleterole', $displayData);
	}
	else 
	{
		$random=random_string('alnum',10);
		$displayData['authUrl'] = GOOGLE_REDIRECT_URI."&state=".$random;
		$displayData['random'] = $random;
		$this->load->view('login', $displayData);
	}
}

public function deletedrole()
{
	$this->load->model('enterprisesmodel');
	$this->enterprisesmodel->deleterole($_POST['role']);
}
}
//changes

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */