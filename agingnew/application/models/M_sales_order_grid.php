<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_sales_order_grid extends CI_Model {
    protected $table = array('1' => 'sales_order_grid','2' => 'sales_order','3' => 'newsletter_subscriber');
    

    public function __construct(){
      parent::__construct();
    }

    //backend
    public function CountComplete() {
        $this->db->select('entity_id');
        $this->db->from($this->table[1]);
        $this->db->where_in('status', array('processing', 'complete'));
        // $this->db->where_in('status', array('processing', 'payment_confirmation', 'preperation_in_progress', 'complete', 'on_delivery_jne', 'pending_payment'));
        $this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function CountRevenue() {
        $this->db->select('sum(base_grand_total) as total');
        $this->db->from($this->table[1]);
        $this->db->where_in('status', array('processing', 'complete'));
        $this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');

        $data = $this->db->get()->row();
        return $data;
    }

    public function CountSubscriber() {
        $this->db->select('subscriber_id');
        $this->db->from($this->table[3]);
        $this->db->where('subscriber_status', 1);

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function CountShipping() {
        $this->db->select('sum(shipping_and_handling) as shipping');
        $this->db->from($this->table[1]);
        $this->db->where('status', 'on_delivery_jne');
        $this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');

        $data = $this->db->get()->row();
        return $data;
    }
    
    public function Kurir(){
        $this->db->select('a.entity_id, a.base_grand_total, a.increment_id, a.shipping_and_handling, b.shipping_description, b.total_item_count');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.entity_id','left');
        $this->db->where('a.status', 'preperation_in_progress');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

}