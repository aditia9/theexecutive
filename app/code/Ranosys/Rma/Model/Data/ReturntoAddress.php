<?php

namespace Ranosys\Rma\Model\Data;

class ReturntoAddress extends \Magento\Framework\Model\AbstractModel implements \Ranosys\Rma\Api\Data\ReturntoAddressInterface {
    
    const KEY_RETURNTONAME = 'returnto_name';
    const KEY_RETURNTOADDRESS = 'returnto_address';
    const KEY_RETURNTOCONTACT = 'returnto_contact';
    
    /**
     * {@inheritdoc}
     */
    public function getReturntoName() {
        return $this->_getData(self::KEY_RETURNTONAME);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReturntoName($returntoName) {
        return $this->setData(self::KEY_RETURNTONAME, $returntoName);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReturntoAddress() {
        return $this->_getData(self::KEY_RETURNTOADDRESS);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReturntoAddress($returntoAddress) {
        return $this->setData(self::KEY_RETURNTOADDRESS, $returntoAddress);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReturntoContact() {
        return $this->_getData(self::KEY_RETURNTOCONTACT);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReturntoContact($returntoContact) {
        return $this->setData(self::KEY_RETURNTOCONTACT, $returntoContact);
    }
    
}