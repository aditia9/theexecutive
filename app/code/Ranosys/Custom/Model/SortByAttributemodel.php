<?php

namespace Ranosys\Custom\Model;

use \Magento\Framework\Api\AttributeValueFactory;

class SortByAttributemodel extends \Magento\Framework\Api\AbstractExtensibleObject implements
\Ranosys\Custom\Api\Data\SortByAttributedataInterface {

    public function __construct(
    \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, AttributeValueFactory $attributeValueFactory, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }

    const ATTRIBUTEID = 'attributeid';
    const ATTRIBUTECODE = 'attributecode';
    const ATTRIBUTENAME = 'attributename';

    /**
     * Get id of attributes
     * @return string
     */
    public function getAttributeId() {
        return $this->_get(self::ATTRIBUTEID);
    }

    /**
     * Get code of attributes
     * @return string
     */
    public function getAttributeCode() {
        return $this->_get(self::ATTRIBUTECODE);
    }

    /**
     * Get name of attributes
     * @return string
     */
    public function getAttributeName() {
        return $this->_get(self::ATTRIBUTENAME);
    }

    /**
     * Set $attributeid
     * 
     * @param int $attributeid
     * @return this
     */
    public function setAttributeId($attributeid) {
        return $this->setData(self::ATTRIBUTEID, $attributeid);
    }

    /**
     * Set $attributecode
     * 
     * @param string $attributecode
     * @return this
     */
    public function setAttributeCode($attributecode) {
        return $this->setData(self::ATTRIBUTECODE, $attributecode);
    }

    /**
     * Set $attributename
     * 
     * @param string $attributename
     * @return this
     */
    public function setAttributeName($attributename) {
        return $this->setData(self::ATTRIBUTENAME, $attributename);
    }

}
