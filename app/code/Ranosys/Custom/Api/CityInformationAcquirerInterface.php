<?php

namespace Ranosys\Custom\Api;

interface CityInformationAcquirerInterface {
    
    /**
     * get all cities associated to the region
     * 
     * @param int $regionId
     * @throws \Magento\Framework\Exception\NotFoundException
     * @return Ranosys\Custom\Api\Data\CityInformationInterface[]
     */
    public function getCitiesInfo($regionId);
    
}