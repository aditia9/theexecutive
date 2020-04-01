<?php

namespace Hypework\ShippingLion\Model\ResourceModel\Carrier;
class CollectionFactory
{
    protected $_objectManager = null;
    
    protected $_instanceName = null;
    
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Hypework\\ShippingLion\\Model\\ResourceModel\\Carrier\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
    
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}