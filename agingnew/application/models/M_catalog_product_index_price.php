<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_catalog_product_index_price extends CI_Model {
    protected $table = array('1' => 'catalog_product_index_price','2' => 'catalog_product_entity','3' => 'cataloginventory_stock_item','4' => 'catalogrule_product','5' => 'catalog_product_entity_varchar','6' => 'catalogrule','7' => 'catalog_product_entity_int');

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

    public function InsertStock($id, $data2) {
        $this->db->where('entity_id',$id);
        $this->db->update($this->table[1],$data2);

        return $data;
    }
    
    public function TarikStock(){
        $this->db->select('a.entity_id, a.type_id, a.sku, b.product_id, b.qty, b.is_in_stock,  c.value');
        $this->db->from($this->table[2].' as a');
        $this->db->join($this->table[3].' as b','b.product_id = a.entity_id','left');
        $this->db->join($this->table[5].' as c','c.entity_id = a.entity_id','left');
        // $this->db->where('a.type_id !=', 'configurable');
        $this->db->where('b.is_in_stock', 1);
        $this->db->where('c.attribute_id', 73);
        $this->db->where('c.store_id', 0);
        $this->db->limit(100, 0);
        $this->db->order_by('a.entity_id', 'DESC');

        $data = $this->db->get()->result();
        return $data;
    }
    
    public function TarikStockExcel(){
        $this->db->select('a.entity_id, a.type_id, a.sku, b.product_id, b.qty, b.is_in_stock, c.value');
        $this->db->from($this->table[2].' as a');
        $this->db->join($this->table[3].' as b','b.product_id = a.entity_id','left');
        $this->db->join($this->table[5].' as c','c.entity_id = a.entity_id','left');
        $this->db->where('b.is_in_stock', 1);
        $this->db->where('c.attribute_id', 73);
        $this->db->where('c.store_id', 0);
        $this->db->order_by('a.entity_id', 'DESC');
        
        $data = $this->db->get()->result();
        return $data;
    }

    public function TarikStockExcelKode($id){
        $this->db->select('value');
        $this->db->from($this->table[5]);
        $this->db->where('entity_id', $id);
        $this->db->where('attribute_id', 73);

        $data = $this->db->get()->row();
        return $data;
    }
}