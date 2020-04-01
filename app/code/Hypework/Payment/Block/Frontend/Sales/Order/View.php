<?php

namespace Hypework\Payment\Block\Frontend\Sales\Order;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Hypework\Payment\Model\PaymentGatewayConfigProvider;

class View extends \Magento\Framework\View\Element\Template{

    private $registry;
    private $logger;
    private $resourceConnection;

    public function __construct(
        Context $context,
        array $data = [],
        Registry $registry,
        ResourceConnection $resourceConnection
    ){
        parent::__construct(
            $context, $data
        );

        $this->registry = $registry;
        $this->logger = $context->getLogger();
        $this->resourceConnection = $resourceConnection;
    }

    private function getOrder()
    {
        return $this->registry->registry('current_order');
    }

    public function getOrderData(){

        $this->logger->info('===== Block View ===== Start');
        try{
            $findOrder = $this->resourceConnection
                ->getConnection()->select()
                ->from('hypework_prismalink_va')
                ->where('order_id=?', $this->getOrder()->getId())
                ->where('store_id=?', $this->getOrder()->getStoreId());
            $rowOrder = $this->resourceConnection->getConnection()->fetchRow($findOrder);
            $orderInfo = ['va_number' => $rowOrder['account_no'], 'increment_id' => $rowOrder['increment_id']];

        }catch(\Exception $e){
            $this->logger->info('===== Block View ===== getOrderData error : '. $e->getMessage());
            $orderInfo = ['channel_id' => '', 'channel name' => ''];
        }
        $this->logger->info('===== Block View ===== End');

        return $orderInfo;
    }
}
