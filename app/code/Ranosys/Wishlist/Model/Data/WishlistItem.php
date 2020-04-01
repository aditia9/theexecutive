<?php

namespace Ranosys\Wishlist\Model\Data;

class WishlistItem extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Wishlist\Api\Data\WishlistItemInterface {
    
    const KEY_ID = 'id';
    const KEY_PRODUCTID = 'product_id';
    const KEY_TYPEID = 'type_id';
    const KEY_QTY = 'qty';
    const KEY_REGULARPRICE = 'regular_price';
    const KEY_FINALPRICE = 'final_price';
    const KEY_SKU = 'sku';
    const KEY_NAME = 'name';
    const KEY_IMAGE = 'image';
    const KEY_OPTIONS = 'options';
    const KEY_STOCKITEM = 'stock_item';
    
    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->_getData(self::KEY_ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setId($id) {
        return $this->setData(self::KEY_ID, $id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProductId() {
        return $this->_getData(self::KEY_PRODUCTID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProductId($productid) {
        return $this->setData(self::KEY_PRODUCTID, $productid);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTypeId() {
        return $this->_getData(self::KEY_TYPEID);;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTypeId($typeId) {
        return $this->setData(self::KEY_TYPEID, $typeId);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getQty() {
        return $this->_getData(self::KEY_QTY);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setQty($qty) {
        return $this->setData(self::KEY_QTY, $qty);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSku(){
        return $this->_getData(self::KEY_SKU);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSku($sku) {
        return $this->setData(self::KEY_SKU, $sku);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return $this->_getData(self::KEY_NAME);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name) {
        return $this->setData(self::KEY_NAME, $name);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getImage() {
        return $this->_getData(self::KEY_IMAGE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setImage($image) {
        return $this->setData(self::KEY_IMAGE, $image);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRegularPrice() {
        return $this->_getData(self::KEY_REGULARPRICE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRegularPrice($regularPrice) {
        return $this->setData(self::KEY_REGULARPRICE, $regularPrice);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFinalPrice() {
        return $this->_getData(self::KEY_FINALPRICE);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFinalPrice($finalPrice) {
        return $this->setData(self::KEY_FINALPRICE, $finalPrice);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getStockItem() {
        return $this->_getData(self::KEY_STOCKITEM);;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStockItem($stockItem) {
        return $this->setData(self::KEY_STOCKITEM, $stockItem);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOptions() {
        return $this->_getData(self::KEY_OPTIONS);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOptions($options) {
        return $this->setData(self::KEY_OPTIONS, $options);
    }
    
}