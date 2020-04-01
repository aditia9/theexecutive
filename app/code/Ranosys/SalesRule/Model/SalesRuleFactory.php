<?php

namespace Ranosys\SalesRule\Model;

class SalesRuleFactory {
    
    protected $_objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }

    public function create(array $arguments = [])
    {
        return $this->_objectManager->create('Ranosys\SalesRule\Model\SalesRule', $arguments, false);
    }
}