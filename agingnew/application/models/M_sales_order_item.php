<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_sales_order_item extends CI_Model {
    protected $table = array('1' => 'sales_order_item','2' => 'sales_order_grid','3' => 'sales_order_address','4' => 'sales_order','5' => 'catalogrule_product','6' => 'agingnomor');
    
    public function __construct(){
      parent::__construct();
    }

    //backend
    public function Taskscomplete() {
        $this->db->select('a.sku, a.name, a.qty_ordered, b.base_grand_total, b.shipping_name');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where('b.status', 'complete');
        $this->db->where('a.product_type', 'simple');
        $this->db->where('a.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function Taskspcr() {
        $this->db->select('a.sku, a.name, a.qty_ordered, b.base_grand_total, b.shipping_name');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where_in('b.status', array('payment_confirmation', 'paymentconfirmationreceive'));
        $this->db->where('a.product_type', 'simple');
        $this->db->where('a.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function Taskspreparation() {
        $this->db->select('a.sku, a.name, a.qty_ordered, b.base_grand_total, b.shipping_name');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where('b.status', 'preperation_in_progress');
        $this->db->where('a.product_type', 'simple');
        $this->db->where('a.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }
    
    public function Tasksondelivery() {
        $this->db->select('a.sku, a.name, a.qty_ordered, b.base_grand_total, b.shipping_name');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where_in('b.status', array('on_delivery_jne', 'on_delivery_lion'));
        $this->db->where('a.product_type', 'simple');
        $this->db->where('a.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }
    
    public function Taskspending() {
        $this->db->select('a.sku, a.name, a.qty_ordered, b.base_grand_total, b.shipping_name');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where('b.status', 'pending_payment');
        $this->db->where('a.product_type', 'simple');
        $this->db->where('a.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }    
    
    public function WaitingBankTransfer(){
        $this->db->select('a.order_id, a.sku, a.qty_ordered, a.name, b.entity_id, b.increment_id, b.grand_total, b.payment_method, b.created_at');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where('a.parent_item_id IS NOT NULL');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');
        $this->db->where_in('b.status', array('pending_payment', 'pending', 'paymentconfirmationreceive'));
        $this->db->where_in('b.payment_method', array('ipay88_cc', 'banktransfer', 'prismalink_vabca', 'cashondelivery'));

        $data = $this->db->get()->result();
        return $data;
    }

    public function WaitingBankTransferExcel(){
        $this->db->select('a.order_id, a.sku, a.qty_ordered, a.name, b.entity_id, b.increment_id, b.grand_total, b.payment_method, b.created_at, b.customer_email, b.shipping_name, b.customer_name, b.status, c.street, c.city, c.postcode, c.telephone, c.region, c.firstname, c.lastname');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','a.order_id = b.entity_id','left');
        $this->db->join($this->table[3].' as c','b.entity_id = c.parent_id','left');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('a.parent_item_id IS NOT NULL');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');
        $this->db->where_in('b.status', array('pending_payment', 'pending', 'paymentconfirmationreceive'));
        $this->db->where_in('b.payment_method', array('ipay88_cc', 'banktransfer', 'prismalink_vabca', 'cashondelivery'));

        $data = $this->db->get()->result();
        return $data;
    }

    public function VirtualAccount(){
        $this->db->select('a.sku, a.name, a.qty_ordered, a.base_original_price, b.increment_id, b.entity_id, a.price, a.discount_amount, b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, c.street, c.city, c.city, c.postcode, c.telephone, c.region, b.created_at, d.base_discount_amount');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.status', 'processing');
        $this->db->where('b.payment_method', 'prismalink_vabca');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function VirtualAccountKode($id){
        $this->db->select('order_id');
        $this->db->from($this->table[1]);
        $this->db->where('order_id', $id);
        $this->db->where('product_type', 'configurable');

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function CashOnDelivery(){
        $this->db->select('a.sku, a.name, a.qty_ordered, b.created_at, b.increment_id, b.grand_total, b.billing_name');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->where('a.parent_item_id', NULL);
        $this->db->where('b.payment_method', 'cashondelivery');
        $this->db->where('b.status !=', 'canceled');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 8 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function CashOnDeliveryExcel(){
        $this->db->select('a.sku, a.name, a.qty_ordered, a.base_original_price, b.increment_id, b.entity_id, a.price, a.discount_amount, b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, c.street, c.city, c.city, c.postcode, c.telephone, c.region, b.created_at, d.base_discount_amount');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.parent_item_id', NULL);
        $this->db->where('b.payment_method', 'cashondelivery');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.status !=', 'canceled');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 8 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function CashOnDeliveryKode($id){
        $this->db->select('order_id');
        $this->db->from($this->table[1]);
        $this->db->where('order_id', $id);
        $this->db->where('product_type', 'configurable');

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function ConfirmationRecive(){
        $this->db->select('a.sku, a.name, a.qty_ordered, a.base_original_price, b.increment_id, b.entity_id, a.price, a.discount_amount, b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, c.street, c.city, c.city, c.postcode, c.telephone, c.region, b.created_at, d.base_discount_amount');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.status', 'paymentconfirmationreceive');
        $this->db->where('b.payment_method', 'banktransfer');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function ConfirmationReciveKode($id){
        $this->db->select('order_id');
        $this->db->from($this->table[1]);
        $this->db->where('order_id', $id);
        $this->db->where('product_type', 'configurable');

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function CreditCard(){
        $this->db->select('a.order_id, a.sku, a.name, a.qty_ordered, a.base_original_price, b.increment_id, b.entity_id, b.status, a.price, a.discount_amount, b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, c.street, c.city, c.city, c.postcode, c.telephone, c.region, b.created_at, d.base_discount_amount');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.status', 'processing');
        $this->db->where('b.payment_method', 'ipay88_cc');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function CreditCardKode($id){
        $this->db->select('order_id');
        $this->db->from($this->table[1]);
        $this->db->where('order_id', $id);
        $this->db->where('product_type', 'configurable');

        $data = $this->db->get()->num_rows();
        return $data;
    }


    public function StockOpnameItem(){
        $this->db->select('entity_id');
        $this->db->from($this->table[4]);
        $this->db->where('status', 'preperation_in_progress');          
	$this->db->where('mailchimp_flag', 0);
        $this->db->where('updated_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->row();
        return $data;
    }


    public function StockOpnameAll(){
        $this->db->select('a.item_id, a.order_id, a.sku, a.name, a.qty_ordered, a.base_original_price, b.increment_id, b.entity_id, b.status, a.price, a.discount_amount, 
        b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, b.payment_method, c.street, c.city, c.postcode, 
        c.telephone, c.region, b.created_at, d.base_discount_amount');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.status', 'preperation_in_progress');
        // $this->db->where('d.entity_id', $id);
        $this->db->where('b.updated_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }


    public function StockOpname($id){

        $this->db->select('a.item_id, a.order_id, a.sku, a.name, a.qty_ordered, a.base_original_price, b.increment_id, b.entity_id, b.status, a.price, a.discount_amount, 
        b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, b.payment_method, c.street, c.city, c.postcode, 
        c.telephone, c.region, b.created_at, d.base_discount_amount');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.status', 'preperation_in_progress');
        $this->db->where('d.entity_id', $id);
        $this->db->where('b.updated_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }


    public function StockOpnameKode($id){
        $this->db->select('name');
        $this->db->from($this->table[1]);
        $this->db->where('sku', $id);
        $this->db->where('product_type', 'simple');

        $data = $this->db->get()->row();
        return $data;
    }

    public function CountSOKode($id){
        $this->db->select('aorder_id');
        $this->db->from($this->table[6]);
        $this->db->where('aorder_id', $id);

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function UpdateProductStockOpname($id){
        $this->db->set('mailchimp_flag', 1);
        $this->db->where('entity_id',$id);
        $this->db->update($this->table[4]);

    }

    public function UpdateStockOpname($id){
        $data = array(
            'aorder_id' => $id,
            'adate' => date('Y-m-d H:i:s')
        );
        $data = $this->db->insert($this->table[6], $data);
        return $data;

    }

    public function Jne(){
        $this->db->select('a.order_id, a.product_id, a.qty_ordered, b.shipping_information, b.shipping_name, b.billing_name, b.base_grand_total, 
            b.shipping_and_handling, c.street, c.city, c.postcode, c.region, c.telephone, d.total_item_count');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where('b.shipping_information', 'JNE Reguler - JNE Reguler Service');
        // $this->db->where_in('b.shipping_information', array('JNE Reguler Service', 'JNE Reguler - JNE Reguler Service'));
        $this->db->where('b.status', 'preperation_in_progress');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }

    public function CountJne($id){
        $this->db->select('order_id');
        $this->db->from($this->table[1]);
        $this->db->where('order_id', $id);
        $this->db->where('product_type', 'simple');

        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function LionParcel(){
        $this->db->select('a.order_id, a.sku, a.name, a.qty_ordered, a.base_original_price, a.price, a.discount_amount, b.increment_id, b.entity_id, b.status, b.grand_total, b.billing_name, b.shipping_and_handling, b.shipping_information, b.shipping_name, b.base_grand_total, c.street, c.city, c.postcode, c.telephone, c.region, d.base_discount_amount, d.total_item_count');
        $this->db->from($this->table[1].' as a');
        $this->db->join($this->table[2].' as b','b.entity_id = a.order_id','left');
        $this->db->join($this->table[3].' as c','c.parent_id = b.entity_id','left');
        $this->db->join($this->table[4].' as d','d.entity_id = a.order_id','left');
        $this->db->where('a.product_type', 'configurable');
        $this->db->where('c.address_type', 'shipping');
        $this->db->where_in('b.shipping_information', array('Lion Parcel - Cash on Delivery', 'Lion Parcel - Bayar Di Tempat'));
        $this->db->where('b.status', 'preperation_in_progress');
        $this->db->where('b.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()');

        $data = $this->db->get()->result();
        return $data;
    }
}
