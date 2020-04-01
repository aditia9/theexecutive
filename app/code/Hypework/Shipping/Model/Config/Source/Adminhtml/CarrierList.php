<?php

namespace Hypework\Shipping\Model\Config\Source\Adminhtml;

class CarrierList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     *
     * @var \Magento\Directory\Model\CityFactory
     */
    protected $_carrierFactory;
    /**
     *
     * @param \Magento\Directory\Model\CityFactory $carrierFactory
     */
    public function __construct(
        \Hypework\Shipping\Model\ResourceModel\Carrier\CollectionFactory $carrierFactory
    ) {
        $this->_carrierFactory = $carrierFactory;
    }

    public function _getFactoryObject()
    {
        return $this->_carrierFactory->create();
    } 

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray($regionId = null)
    {
        $carriers = $this->_getFactoryObject()->load();

        $results = [];
        foreach ($carriers as $carrier) {
            $results[] = [
                'value' => $carrier->getEntityId(),
                'label' => trim($carrier->getName()),
            ];
        }
        return $results;
    }
}