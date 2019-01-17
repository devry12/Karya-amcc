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

	public function loginadmin()
	{
		if (isset($_SESSION['admin'])) {
			redirect('/admin/wait');
		}
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('password','password','trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('/login/index');
		}else {
			// die();
			if ($this->AuthModel->loginAdmin() == 'berhasil') {
				redirect('/admin/wait');
			}else {
				$this->session->set_flashdata('error_pass', 'Username atau password anda salah');
				redirect('/login/admin','refresh');
			}
		}
	}

	// function CheckPassword()
	// 	{
	// 				$this->form_validation->set_message('CheckPassword','Username atau password anda salah');
	// 				return false;
	// 	}

}
