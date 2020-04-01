<?php

namespace Ranosys\Custom\Model;

use Magento\Framework\Exception\NotFoundException;

class CityInformationAcquirer implements \Ranosys\Custom\Api\CityInformationAcquirerInterface {
    
    /**
     *
     * @var \Ranosys\Custom\Model\Data\CityInformationFactory
     */
    protected $cityInformationFactory;
    
    /**
     *
     * @var \Hypework\Shipping\Model\CityFactory
     */
    protected $cityFactory;
    
    public function __construct(
        \Ranosys\Custom\Model\Data\CityInformationFactory $cityInformationFactory,
        \Hypework\Shipping\Model\CityFactory $cityFactory
    ) {
        $this->cityInformationFactory = $cityInformationFactory;
        $this->cityFactory = $cityFactory;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCitiesInfo($regionId) {
        
        $cityInformationArray = [];
        
        $cityModel = $this->cityFactory->create();
        $cityCollection = $cityModel->getCollection()->addFieldToFilter('region_id', array('eq' => $regionId));
        
        if(!$cityCollection->count()){
            throw new NotFoundException(__('Cities not available for regionid.'));
        }
        
        foreach($cityCollection as $city){
            $cityInformationModel = $this->cityInformationFactory->create();
            $cityInformationModel->setName(__($city->getName()));
            $cityInformationModel->setValue($city->getId());
            $cityInformationArray[] = $cityInformationModel;
        }
        
        return $cityInformationArray;
    }
}