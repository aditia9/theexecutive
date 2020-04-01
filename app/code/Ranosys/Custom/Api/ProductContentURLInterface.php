<?php

namespace Ranosys\Custom\Api;


/**
 * Get product CMS Page URL's
 */
interface ProductContentURLInterface {

    /**
     * Return array
     *
     * @api
     * @param 
     * @return \Ranosys\Custom\Api\Data\ProductURLdataInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getContentURL();
}