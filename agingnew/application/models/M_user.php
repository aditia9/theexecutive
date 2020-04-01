<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_user extends CI_Model {
    protected $table = array('1' => 'aginguser');

    public function __construct(){
      parent::__construct();
    }

    //halaman backend
    function cek_login($where){      
        return $this->db->get_where($this->table[1], $where);
    }

    function data_login($user,$pass){      
        $this->db->select('aid, aname, arole');
        $this->db->from($this->table[1]);
        $this->db->where('ausername', $user);
        $this->db->where('apassword', $pass);

        $data = $this->db->get()->row();
        return $data;
    }

    public function User(){
        $this->db->select('*');
        $this->db->from($this->table[1]);
        $this->db->where('astatus', 1);

        $data = $this->db->get()->result();
        return $data;
    }

    public function SaveUser($data) {
        $data = $this->db->insert($this->table[1], $data);
        return $data;
    }

    public function DetailUser($id){
        $this->db->select('*');
        $this->db->from($this->table[1]);
        $this->db->where('astatus', 1);
        $this->db->where('aid', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function EditUser($id, $data) {
        $this->db->where('aid',$id);
        $this->db->update($this->table[1],$data);

        return $data;
    }

    public function HapusUser($id){
        $this->db->set('astatus', 0);
        $this->db->where('aid',$id);
        $this->db->update($this->table[1]);
    }

}