<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cataloginventory_stock_item extends CI_Model {
    protected $table = array('1' => 'cataloginventory_stock_item');

    public function __construct(){
      parent::__construct();
    }

    //backend
    public function CStock() {
        $this->db->select('product_id');
        $this->db->from($this->table[1]);

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function InsertStock($id, $data) {
        $this->db->where('product_id',$id);
        $this->db->update($this->table[1],$data);

        return $data;
    }
}