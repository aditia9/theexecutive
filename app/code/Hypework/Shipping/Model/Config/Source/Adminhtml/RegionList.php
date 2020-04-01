<?php

namespace Hypework\Shipping\Model\Config\Source\Adminhtml;

class RegionList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     *
     * @var \Magento\Directory\Model\RegionFactory
     */
    protected $_regionFactory;
    /**
     *
     * @param \Magento\Directory\Model\RegionFactory $regionFactory
     */
    public function __construct(
        \Magento\Directory\Model\RegionFactory $regionFactory
    ) {
        $this->_regionFactory = $regionFactory;
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $regions = $this->_regionFactory->create()->getCollection()
        			->addFieldToFilter('country_id', 'ID')
        			->load();

        $results[] = [
            'value' => -1,
            'label' => __('-- Please Select Region --'),
        ];
        foreach ($regions as $region) {
            $results[] = [
                'value' => $region->getRegionId(),
                'label' => trim($region->getDefaultName()),
            ];
        }
        return $results;
    }
}