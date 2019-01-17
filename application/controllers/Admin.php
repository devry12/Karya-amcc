<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
  {
    parent::__construct();
    $this->load->model('AuthModel');
		$this->load->library('grocery_CRUD');
		if (!isset($_SESSION['admin'])) {
			redirect('/');
		}

  }


	public function posts()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('karya');
		$crud->where('status','menunggu');
		$crud->unset_add();
		$crud->unset_export();
		$crud->unset_print();
		$crud->unset_delete();
		$crud->columns(array('judul_karya','link_karya','file_karya','id_member'));
		$crud->display_as('judul_karya','Judul');
		$crud->display_as('link_karya','Link');
		$crud->display_as('file_karya','File');
		$crud->display_as('id_member','Member');
		$crud->edit_fields('status');
		$output = $crud->render();
		$this->load->view('/admin/posts',$output);

	}

	public function posts_publish()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('karya');
		$crud->where('status','setuju');
		$crud->unset_add();
		$crud->unset_export();
		$crud->unset_print();
		$crud->unset_delete();
		$crud->columns(array('judul_karya','link_karya','file_karya','id_member'));
		$crud->display_as('judul_karya','Judul');
		$crud->display_as('link_karya','Link');
		$crud->display_as('file_karya','File');
		$crud->display_as('id_member','Member');
		$crud->edit_fields('status');
		$output = $crud->render();
		$this->load->view('/admin/posts',$output);

	}

}
