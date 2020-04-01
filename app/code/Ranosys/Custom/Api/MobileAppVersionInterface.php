<?php

namespace Ranosys\Custom\Api;


/**
 * Check mobile app version
 */
interface MobileAppVersionInterface {

    /**
     * Return array
     *
     * @api
     * @param string $os
     * @return \Ranosys\Custom\Api\Data\MobileAppVersiondataInterface
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getConfiguration($os);
}
