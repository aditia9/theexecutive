<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_catalog_product_entity extends CI_Model {
    protected $table = array('1' => 'catalog_product_entity','2' => 'cataloginventory_stock_cl','3' => 'cataloginventory_stock_item',
        '4' => 'cataloginventory_stock_status_replica','5' => 'catalogrule_product_cl','6' => 'catalogsearch_fulltext_cl','7' => 'catalogsearch_fulltext_scope1',
        '8' => 'catalogsearch_fulltext_scope2','9' => 'catalog_category_product','10' => 'catalog_category_product_index','11' => 'catalog_product_attribute_cl',
        '12' => 'catalog_product_category_cl','13' => 'catalog_product_entity_decimal','14' => 'catalog_product_entity_text','15' => 'catalog_product_entity_int',
        '16' => 'catalog_product_entity_media_gallery','17' => 'catalog_product_entity_media_gallery_value',
        '18' => 'catalog_product_entity_media_gallery_value_to_entity','19' => 'catalog_product_entity_varchar','20' => 'catalog_product_flat_1',
        '21' => 'catalog_product_flat_2','22' => 'catalog_product_index_price','23' => 'catalog_product_index_price_replica','24' => 'catalog_product_relation',
        '25' => 'catalog_product_super_attribute','26' => 'catalog_product_super_link','27' => 'catalog_product_website','28' => 'url_rewrite',
        '29' => 'catalog_url_rewrite_product_category','42' => 'catalog_category_entity_varchar','43' => 'eav_attribute_option_value',
        '44' => 'catalog_category_entity_varchar','45' => 'cataloginventory_stock_status','46' => 'catalog_category_product_index_tmp',
        '47' => 'catalog_product_entity_datetime');

    public function __construct(){
      parent::__construct();
    }

    //backend
    public function InsertCatalogProductEntity($data) {
        $data = $this->db->insert($this->table[1], $data);
        return $data;
    }

    public function GetCatalogProductEntity($sku){   
        $this->db->select('entity_id');
        $this->db->from($this->table[1]);
        $this->db->like('sku', $sku);        

       	$data = $this->db->get()->row();
        return $data;
    }

    public function GetCatalogProductEntityParent($sku){   
        $this->db->select('entity_id');
        $this->db->from($this->table[1]);
        $this->db->like('sku', $sku, 'both');        
	$this->db->where('type_id', 'configurable');

       	$data = $this->db->get()->row();
        return $data;
    }

    public function InsertCatalogInventoryStock($data) {
        $data = $this->db->insert($this->table[2], $data);
        return $data;
    }

    public function InsertCatalogInventoryStockItem($data) {
        $data = $this->db->insert($this->table[3], $data);
        return $data;
    }

    public function InsertcatalogInventoryStockStatus($data) {
        $data = $this->db->insert($this->table[45], $data);
        return $data;
    }

    public function InsertcatalogCategoryProductTmp($data) {
        $data = $this->db->insert($this->table[46], $data);
        return $data;
    }

    public function InsertcatalogProdukDateTime($data) {
        $data = $this->db->insert($this->table[47], $data);
        return $data;
    }

    public function InsertcatalogInventoryStockStatusReplica($data) {
        $data = $this->db->insert($this->table[4], $data);
        return $data;
    }

    public function InsertcatalogruleProductCl($data) {
        $data = $this->db->insert($this->table[5], $data);
        return $data;
    }

    public function InsertcatalogSearchFulltextCl($data) {
        $data = $this->db->insert($this->table[6], $data);
        return $data;
    }

    public function InsertcatalogSearchFulltextScope1($data) {
        $data = $this->db->insert($this->table[7], $data);
        return $data;
    }

    public function InsertcatalogSearchFulltextScope2($data) {
        $data = $this->db->insert($this->table[8], $data);
        return $data;
    }

    public function InsertcatalogCategoryProduct($data) {
        $data = $this->db->insert($this->table[9], $data);
        return $data;
    }

    public function GetCatalogProduct($id){      
        $this->db->select('entity_id');
        $this->db->from($this->table[42]);
        $this->db->where('value', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogCategoryProductIndex($data) {
        $data = $this->db->insert($this->table[10], $data);
        return $data;
    }

    public function InsertcatalogProductAttributeCl($data) {
        $data = $this->db->insert($this->table[11], $data);
        return $data;
    }

    public function InsertcatalogProductCategoryCl($data) {
        $data = $this->db->insert($this->table[12], $data);
        return $data;
    }

    public function InsertcatalogProductEntityDecimal($data) {
        $data = $this->db->insert($this->table[13], $data);
        return $data;
    }

    public function InsertcatalogProductEntityText($data) {
        $data = $this->db->insert($this->table[14], $data);
        return $data;
    }

    public function GetColorProduct($id){      
        $this->db->select('value, option_id');
        $this->db->from($this->table[43]);
        $this->db->where('value', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogProductEntityInt($data) {
        $data = $this->db->insert($this->table[15], $data);
        return $data;
    }

    public function InsertcatalogProductEntityMediaGallery($data) {
        $data = $this->db->insert($this->table[16], $data);
        return $data;
    }

    public function GetCatalogProductEntityMediaGallery($sku){      
        $this->db->select('value_id');
        $this->db->from($this->table[16]);
        $this->db->where('value', $sku);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogProductEntityMediaGalleryValue($data) {
        $data = $this->db->insert($this->table[17], $data);
        return $data;
    }

    public function InsertcatalogProductEntityMediaGalleryValueToEntity($data) {
        $data = $this->db->insert($this->table[18], $data);
        return $data;
    }

    public function InsertcatalogProductEntityVarchar($data) {
        $data = $this->db->insert($this->table[19], $data);
        return $data;
    }

    public function GetMaterialProduct($id){      
        $this->db->select('option_id');
        $this->db->from($this->table[43]);
        $this->db->where('value', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogProductFlat1($data) {
        $data = $this->db->insert($this->table[20], $data);
        return $data;
    }

    public function InsertcatalogProductFlat2($data) {
        $data = $this->db->insert($this->table[21], $data);
        return $data;
    }

    public function InsertcatalogProductIndexPrice($data) {
        $data = $this->db->insert($this->table[22], $data);
        return $data;
    }

    public function InsertcatalogProductIndexPriceReplica($data) {
        $data = $this->db->insert($this->table[23], $data);
        return $data;
    }

    public function InsertcatalogProductRelation($data) {
        $data = $this->db->insert($this->table[24], $data);
        return $data;
    }

    public function InsertcatalogProductSuperAttribute($data) {
        $data = $this->db->insert($this->table[25], $data);
        return $data;
    }

    public function InsertcatalogProductSuperLink($data) {
        $data = $this->db->insert($this->table[26], $data);
        return $data;
    }

    public function InsertcatalogProductWebsite($data) {
        $data = $this->db->insert($this->table[27], $data);
        return $data;
    }

    public function GetLinkCatalogCategoryEntityVarchar($id){      
        $this->db->select('value');
        $this->db->from($this->table[44]);
        $this->db->where('entity_id', $id);
        $this->db->where('attribute_id', 117);

        $data = $this->db->get()->row();
        return $data;
    }

    public function GetIDCatalogCategoryEntityVarchar($id){      
        $this->db->select('entity_id');
        $this->db->from($this->table[44]);
        $this->db->where('value', $id);
        $this->db->where('attribute_id', 45);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertUrlRewrite($data) {
        $data = $this->db->insert($this->table[28], $data);
        return $data;
    }

    public function GetCatalog($id){      
        $this->db->select('url_rewrite_id');
        $this->db->from($this->table[28]);
        $this->db->where('request_path', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogUrlRewriteProductCategory($data) {
        $data = $this->db->insert($this->table[29], $data);
        return $data;
    }

}