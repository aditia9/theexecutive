<?php

namespace Hypework\Shipping\Model\ResourceModel\Region;

class CollectionFactory
{
    protected $_objectManager = null;
    
    protected $_instanceName = null;
    
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Hypework\\Shipping\\Model\\ResourceModel\\Region\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
    
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}