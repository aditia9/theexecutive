<?php

namespace Ranosys\Wishlist\Model\Data;

class WishlistInformation extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Wishlist\Api\Data\WishlistInformationInterface {
    
    const KEY_ID = 'id';
    const KEY_ITEMSCOUNT = 'items_count';
    const KEY_NAME = 'name';
    const KEY_ITEMS = 'items';
    
    /**
     * {@inheritdoc}
     */
    public function getId(){
        return $this->_getData(self::KEY_ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setId($id){
        return $this->setData(self::KEY_ID, $id);
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
    public function getItemsCount() {
        return $this->_getData(self::KEY_ITEMSCOUNT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setItemsCount($itemsCount) {
        return $this->setData(self::KEY_ITEMSCOUNT, $itemsCount);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getItems(){
        return $this->_getData(self::KEY_ITEMS);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setItems($items){
        return $this->setData(self::KEY_ITEMS, $items);
    }
    
}