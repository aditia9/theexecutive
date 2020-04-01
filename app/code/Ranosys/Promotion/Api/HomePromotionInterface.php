<?php

namespace Ranosys\Promotion\Api;


/**
 * Get media and category base URLs
 */
interface HomePromotionInterface {

    /**
     * Return array
     *
     * @api
     * @param 
     * @return \Ranosys\Promotion\Api\Data\GridInterface[]
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getHomePromotion();
}
