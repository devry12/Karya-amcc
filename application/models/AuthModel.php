<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model {


public function login()
{
  $member = $this->load->database('member',TRUE);
// die($this->input->post('nim'));
  $member->select("*");
  $member->from("members");
  $member->where("nim",$this->input->post('nim'));
  $data  = $member->get();
  $datas = $data->result_array();
  $count = $data->num_rows();

  if (password_verify($this->input->post('password'),$datas[0]['password'])) {
    $_SESSION['name'] = $datas[0]['name'];
    return true;
  }else {
    return false;
  }
}


}
