<?php

namespace Hypework\Shipping\Model\Config\Source\Adminhtml;

class CityList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     *
     * @var \Magento\Directory\Model\CityFactory
     */
    protected $_cityFactory;
    /**
     *
     * @param \Magento\Directory\Model\CityFactory $cityFactory
     */
    public function __construct(
        \Hypework\Shipping\Model\ResourceModel\City\CollectionFactory $cityFactory
    ) {
        $this->_cityFactory = $cityFactory;
    }

    public function _getFactoryObject()
    {
        return $this->_cityFactory->create();
    } 

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray($regionId = null)
    {
        $cities = $this->_getFactoryObject();

        if($regionId != '') {
			$cities->addFieldToFilter('region_id', $regionId);
        }
		$cities->load();

        $results = [];
        foreach ($cities as $city) {
            $results[] = [
                'value' => $city->getEntityId(),
                'label' => trim($city->getName()),
            ];
        }
        return $results;
    }
}