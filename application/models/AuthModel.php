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

public function loginAdmin()
{
// die($this->input->post('nim'));
  $this->db->select('*');
  $this->db->from('backend_users');
  $this->db->where('email',$this->input->post('email'));
  $query = $this->db->get();
  $result = $query->result_array();
  $row    = $query->num_rows();
  if ($row == 1) {
  if (password_verify($this->input->post('password'),$result[0]['password'])) {
    $_SESSION['admin'] = $result[0]['login'];
    return "berhasil";
  }else {
    return "gagal";
  }
}else {
  return "gagal";
}
}


}
