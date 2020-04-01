<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 4/7/18
 * Time: 12:41 PM
 */
namespace Hypework\Payment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Store\Model\App\Emulation as AppEmulation;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DataObject;
use Magento\Framework\Mail\Template\TransportBuilder;
use Hypework\Payment\Logger\Logger;
use Hypework\Payment\Model\PaymentGatewayConfigProvider;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CheckoutSubmitAllAfter implements ObserverInterface
{
    protected $_objectManager;
    protected $storeManager;
    protected $appEmulation;
    protected $logger;
    protected $resourceConnection;
    protected $config;
    protected $dataObject;
    protected $transportBuilder;
    protected $scopeConfig;

    /**
     * CheckoutSubmitAllAfter constructor.
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param StoreManager $storeManager
     * @param AppEmulation $appEmulation
     * @param Logger $logger
     * @param ResourceConnection $resourceConnection
     * @param PaymentGatewayConfigProvider $config
     * @param DataObject $dataObject
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        StoreManager $storeManager,
        AppEmulation $appEmulation,
        Logger $logger,
        ResourceConnection $resourceConnection,
        PaymentGatewayConfigProvider $config,
        DataObject $dataObject,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        date_default_timezone_set('Asia/Jakarta');
        $this->_objectManager = $objectManager;
        $this->storeManager = $storeManager;
        $this->appEmulation = $appEmulation;
        $this->logger = $logger;
        $this->resourceConnection = $resourceConnection;
        $this->config = $config;
        $this->dataObject = $dataObject;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $order = $observer->getEvent()->getOrder();

        try {
            $paymentCode = @$order->getPayment()->getMethodInstance()->getCode();
            //does not have invoices
            if (!$order->hasInvoices()) {
                $this->logger->info('===== checkoutDone ===== Start');

                if ($paymentCode == 'prismalink_vabca') {
                    //$merchantkey    = $this->scopeConfig->getValue('payment/prismalink_vabca/partner_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                    //$merchantcode   = $this->scopeConfig->getValue('payment/prismalink_vabca/shared_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                    $prefixbin      = $this->scopeConfig->getValue('payment/prismalink_vabca/prefix_bin', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                    $prefixtrans    = $this->scopeConfig->getValue('payment/prismalink_vabca/prefix_trans', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                    $acountNo = $prefixbin . $order->getIncrementId() . $prefixtrans;
                    $this->resourceConnection->getConnection()->insert('hypework_prismalink_va', [
                        'store_id' => $order->getStore()->getStoreId(),
                        'order_id' => $order->getId(),
                        'status' => 'PENDING',
                        'increment_id' => $order->getIncrementId(),
                        'account_no' => $acountNo,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }

                $order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                $order->setStatus(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                $order->save();

                $this->logger->info('===== checkoutDone ===== order => '. $order->getIncrementId()." payment method : ".$paymentCode);
                $this->logger->info('===== checkoutDone ===== Updating complete');
                $this->logger->info('===== checkoutDone ===== Checking status...');
                $this->logger->info('===== checkoutDone ===== Checking status = '.$order->getStatus());
                $this->logger->info('===== checkoutDone ===== Checking state = '.$order->getState());
            }
            $this->logger->info('===== checkoutDone ===== Checking done');
        } catch (\Exception $e) {
            $this->logger->info('error : ' . $e->getMessage());
        }

        $this->logger->info('===== checkoutDone ===== End');
        $this->appEmulation->stopEnvironmentEmulation();
        return;
    }

}
