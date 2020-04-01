<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_catalog_product_entity_decimal extends CI_Model {
    protected $table = array('1' => 'catalog_product_entity_decimal');

    public function __construct(){
      parent::__construct();
    }

    //backend
    public function CStock() {
        $this->db->select('entity_id');
        $this->db->from($this->table[1]);

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function InsertStock($id, $data3) {
        $this->db->where('entity_id',$id);
        $this->db->where('attribute_id', 77);
        $this->db->update($this->table[1],$data3);

        return $data;
    }
}