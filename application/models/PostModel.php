<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PostModel extends CI_Model {

  public function insertKarya($name)
  {
    $data = [
      'judul_karya'     => $this->input->post('judulkarya'),
      'deskipsi_karya	' => $this->input->post('deskkarya'),
      'link_karya'      => $this->input->post('linkkarya'),
      'img_karya'       => $this->input->post('img-karya'),
      'file_karya'      => $name,
      'id_member'       => $_SESSION['nim'],
    ];
    // die(print_r($data));
    $this->db->insert('karya', $data);
  }

  public function loadPost()
  {
    $this->db->select("*");
    $this->db->from("karya");
    $this->db->limit($this->input->post('row'),$this->input->post('rowperpage'));

    $query = $this->db->get();
    return $query->result_array();
  }
}
