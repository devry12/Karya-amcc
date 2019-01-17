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

  public function loadPost($search)
  {
    $member = $this->load->database('default',TRUE);
    $member = $this->load->database('member',TRUE);


    // $this->sqlStr = "SELECT * FROM amcc_site.karya WHERE amcc_site.karya.id_member ORDER BY created_at DESC LIMIT $row"

    $this->db->select("*");
    $this->db->from("amcc_site.karya");
    $this->db->join('amcc_member.members', 'amcc_member.members.nim = karya.id_member');
    $this->db->where('status','setuju');
    $this->db->order_by("karya.created_at", "DESC");
    $this->db->like('judul_karya', $search);
    // $this->db->limit($row);
    $query = $this->db->get();
    return $query->result_array();
    // die(print_r($query->result_array())) ;
  }
}
