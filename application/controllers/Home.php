<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function __construct()
  {
    parent::__construct();
    $this->load->library('upload');
    $this->load->model('PostModel');
  }
	public function index()
	{
		$this->load->view('/front/home');
	}
	public function uploaddump()
	{
		$this->load->view('dump');
	}



	public function uploadfilekarya()
	{
		$this->load->helper('googledrive');
		$data['res'] = [];
		$config['upload_path']          = 'storage/karya';
		$config['allowed_types'] 				= 	'zip';
		$config['overwrite'] 						= true;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('filekarya'))
                {

                      $data['res']['message'] =  $this->upload->display_errors('', '');

                }else {
									// die(print_r($this->upload->data()));
									$filename = $this->upload->data('file_name');
									$filetype = $this->upload->data('file_type');
									$fullpath = $this->upload->data('full_path');
									$filekaryaupload = uploadtodrive($filename,$filetype,$fullpath);
									unlink($_SERVER['DOCUMENT_ROOT'].'/storage/karya/'.$filename);
									$config['upload_path']          = 'storage/thumbnail-karya';
									$config['allowed_types'] 				= 	'jpg|png|jpeg';
									$config['overwrite'] 						= true;

									$this->load->library('upload', $config);
									$this->upload->initialize($config);
									if ( ! $this->upload->do_upload('thum'))
												{
															$data['res']['message'] =  "gambar".$this->upload->display_errors('', '');

												}else {
													$filenamethum = $this->upload->data('file_name');
													$this->PostModel->insertKarya($filekaryaupload);
													$data['res']['message'] =  "ok";
												}
                }
								echo json_encode($data['res']['message']);

	}

public function googleAuth(){
	require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

	session_start();

	$client = new Google_Client();
	$client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/storage/secret/credentials.json');
	$client->setAccessType("offline");
	$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	  $client->setAccessToken($_SESSION['access_token']);
	  $drive = new Google_Service_Drive($client);
	  $files = $drive->files->listFiles(array())->getItems();
	  echo json_encode($files);
	} else {
	  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/home/oauth2callback';
		// die($redirect_uri);
	  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}
}
public function oauth2callback(){
	require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

	session_start();

	$client = new Google_Client();
	$client->setAuthConfigFile($_SERVER['DOCUMENT_ROOT'].'/storage/secret/credentials.json');
	$client->setAccessType("offline");
	$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/home/oauth2callback');
	$client->addScope(Google_Service_Drive::DRIVE);

	if (! isset($_GET['code'])) {
	  $auth_url = $client->createAuthUrl();
	  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
	} else {
	  $client->authenticate($_GET['code']);
	  $_SESSION['access_token'] = $client->getAccessToken();
	  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
	  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}
}


public function loadPost()
{
	$data = $this->PostModel->loadPost();
	foreach ($data as $item ) {
		$response_arr[] = array(
		'id_karya'=>$item['id_karya'],
		'judul_karya'=>$item['judul_karya'],
		'img_karya'=>$item['img_karya'],
		'deskipsi_karya'=>$item['deskipsi_karya'],
		'link_karya'=>$item['link_karya'],
		'file_karya'=>$item['file_karya'],
		'id_member'=>$item['id_member'],
		'created_at'=>$item['created_at'],
		'image_profile'=>"http://www.amikom.ac.id/public/fotomhs/20".substr($item['id_member'],0,2)."/".str_replace(".","_",$item['id_member']).".jpg",
	);

	}
	echo json_encode($response_arr);
	exit;
}

}
