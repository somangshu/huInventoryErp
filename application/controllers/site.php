<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use MetzWeb\Instagram\Instagram;

class site extends CI_Controller 
{	
	public function index()
	{ 
		$this->home();
	}
	
	public function home()
	{
		$this->load->view("home");
	}
	
	public function about()
	{
		$data['title'] = "About";
		$this->load->view("viewabout", $data);
	}
	
	public function data()
	{
		
	}
	
	public function hash()
	{
		$this->load->model("enterprisemodel");
		
		$images = array();
		$data['title'] = "Images";
		require_once 'api/src/Instagram.php';
		
		$this->load->library('session');
		$sessionUserData = $this->session->all_userdata();
		$displayData['sessionUserData']=$sessionUserData;
	
		$instagram = new Instagram(array(
				'apiKey'      => INSTA_KEY,
				'apiSecret'   => INSTA_SECRET,
				'apiCallback' => 'INSTAGRAM_APP_CALLBACK'
		));

		$instagram = new Instagram(INSTA_KEY);
		$tag = 'happilyunmarried';
		$media = $instagram->getTagMedia($tag);
		$result = 0;
		$limit = 20;
		$size = '320';
		$loop = 0;
		
		try 
		{
			do 
			{
				$tuple = 'INSERT into insta_images (image_url, likes, automatic_tag, user_name, image_tags, source) VALUES ';
				foreach(array_slice($media->data, 0, $limit) as $imagedata)
				{
					$loop++;
        			$tuple .= "(";
					$tuple .= '"'.$imagedata->images->thumbnail->url.'"';
					$tuple .= ', '.$imagedata->likes->count;
					$tuple .= ', "'.$tag;
					if(isset($imagedata->caption->from->username))
						$tuple .= '", "'.$imagedata->caption->from->username;
					else 
						$tuple .= '", "NO USERNAME FOUND';
					$tuple .= '", "'.implode(", ", $imagedata->tags);
					$tuple .= '", "web"';
					$tuple .= "), ";
				}
				$sub = strrchr($tuple, ",");
				$tuple = trim($tuple, $sub);
				$tuple .= ";";
		
				$result = $this->enterprisemodel->insertInstagramImages($tuple);
				if(!$result)
				{
					throw Exception("Error in insert to db.");
				}
				$media = $instagram->pagination($media);			
			}while(isset($media->pagination->next_max_id));
		}
		catch(Exception $e)
		{
			echo "<h1><b>EXCEPTION</b></h1>".$e->$message;
			die();
		}
				
		$this->load->view("images");
	}
}