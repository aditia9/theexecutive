<?php

namespace Ranosys\Rma\Api;


/**
 * Get status of RMA
 */
interface ProductRmaInterface {

    /**
     * Return string
     *
     * @api
     * @param mixed $rmaData
     * @return string Rma status
     * @throws \Magento\Framework\Exception\InputException
     */
    public function execute($rmaData);
}
