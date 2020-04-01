<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_catalog_category_product extends CI_Model {
    protected $table = array('1' => 'catalog_category_product');

    public function __construct(){
      parent::__construct();
    }

    //backend
    public function CCatalog() {
        $this->db->select('entity_id');
        $this->db->from($this->table[1]);

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function InsertCatalog($data) {
        $data = $this->db->insert($this->table[1], $data);
        return $data;
    }

    public function DeleteCatalog($idproduct, $idcategory){
        $this->db->where('product_id',$idproduct);
        $this->db->where('category_id',$idcategory);
        $this->db->delete($this->table[1]);
    }
}