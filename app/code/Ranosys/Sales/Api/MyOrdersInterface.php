<?php

namespace Ranosys\Sales\Api;


/**
 * Get Customers Order List
 */
interface MyOrdersInterface {

    /**
     * Return array
     *
     * @api
     * @param int $customerId
     * @return \Ranosys\Sales\Api\Data\MyOrdersdataInterface[]
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getmyOrders($customerId);
    
    /**
     * Return array
     *
     * @api
     * @param string $orderId
     * @param int $customerId
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getDetail($orderId, $customerId);
    /**
     * 
     *
     * @api
     * @param string $orderId
     * @param int $customerId
     * @return \Ranosys\Sales\Api\Data\OrderSuccessDetailInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOrderStatusInformation($orderId, $customerId);
    /**
     * 
     *
     * @api
     * @param string $orderId
     * @param int $customerId
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function cancelMyOrder($orderId, $customerId);
}
