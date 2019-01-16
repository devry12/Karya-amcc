<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
  {
    parent::__construct();
    $this->load->model('AuthModel');
  }

	public function index()
	{
		$this->load->view('/front/home');
	}
	public function login()
	{
		if (empty($this->input->post('nim')) && empty($this->input->post('password'))) {
			echo "empty";
		}else {
				if ($this->AuthModel->login()) {
					$_SESSION['nim'] = $this->input->post('nim');
					echo "berhasil";
				}else {
					echo "gagal";
				}
		}
	}

}
