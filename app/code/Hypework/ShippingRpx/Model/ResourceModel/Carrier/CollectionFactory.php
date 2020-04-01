<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/18/18
 * Time: 8:35 PM
 */
namespace Hypework\ShippingRpx\Model\ResourceModel\Carrier;
class CollectionFactory
{
    protected $_objectManager = null;
    
    protected $_instanceName = null;
    
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Hypework\\ShippingRpx\\Model\\ResourceModel\\Carrier\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
    
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}