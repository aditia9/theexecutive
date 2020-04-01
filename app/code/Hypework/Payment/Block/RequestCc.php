<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/12/18
 * Time: 6:28 AM
 */

namespace Hypework\Payment\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Sales\Model\Order;
use \Magento\Checkout\Model\Session;
use \Magento\Framework\App\ResourceConnection;
use \Magento\Framework\App\Request\Http;
use \Hypework\Payment\Model\PaymentGatewayConfigProvider;
use \Hypework\Payment\Helper\Data;

class RequestCc extends \Magento\Framework\View\Element\Template
{
    protected $session;
    protected $order;
    protected $logger;
    protected $resourceConnection;
    protected $config;
    protected $helper;
    protected $request;
    const CURRENCY = 'IDR';
    const PAYMENT_ID = 1;

    public function __construct(
        Session $session,
        Order $order,
        ResourceConnection $resourceConnection,
        PaymentGatewayConfigProvider $config,
        Data $helper,
        Template\Context $context,
        Http $request,
        \Hypework\Payment\Logger\Logger $logger,
        array $data = []
    ) {

        parent::__construct($context, $data);

        $this->session = $session;
        $this->logger = $logger;
        $this->order = $order;
        $this->resourceConnection = $resourceConnection;
        $this->config = $config;
        $this->helper = $helper;
        $this->request = $request;
    }

    public function getFormData() {
        //var_dump(get_class_methods($this->session));exit;
        $incrementId = $_SESSION['checkout']['last_real_order_id'];
        $orderId = $_SESSION['checkout']['last_order_id'];

        $this->logger->info('===== Request block ===== Start');
        $this->logger->info('===== Request block ===== Find Order');

        $order = $this->order->loadByIncrementId($incrementId);
        $om = \Magento\Framework\App\ObjectManager::getInstance();

        $result = [];
        if ($order->getId()) {
            $order->setState(Order::STATE_PENDING_PAYMENT);
            $order->setStatus(Order::STATE_PENDING_PAYMENT);
            $order->save();
            $this->logger->info('===== Request block ===== Order Found!');

            /*
            Example:
            MerchantKey = “apple”
            MerchantCode = “ID00001”
            RefNo = “A00000001”
            Amount = “300000” (Note: 300000 represent amount as Rp 3.000,00) Currency = “IDR”
            The hash would be calculated on the following string:
            applekeyID00001A00000001300000IDR
            */
            $billingAddress = $order->getBillingAddress();
            $config = $this->config->getConfig();
            $grandTotal = str_replace('.0000', '', $order->getGrandTotal()) . '00';
            $merchantkey = $config['payment']['ipay88_cc']['merchant_key'];
            $merchantcode = $config['payment']['ipay88_cc']['merchant_code'];
            $baseUrl = $om->create('\Magento\Store\Model\StoreManagerInterface')->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
            //$baseUrl = 'http://delami.executive.me/';
            $source = $merchantkey. $merchantcode. $order->getIncrementId() . $grandTotal . self::CURRENCY;
            $signature = $this->ipay88Signature($source);
            $result = [
                'URL' => $config['payment']['ipay88_cc']['request_url'],
                'MerchantCode' => $merchantcode,
                'PaymentId' => self::PAYMENT_ID,
                'RefNo' => $order->getIncrementId(),
                'Amount' => $grandTotal,
                'Currency' => self::CURRENCY,
                'ProdDesc' => 'THEEXECUTIVE',
                'UserName' => $billingAddress->getData('firstname') . ' ' . $billingAddress->getData('lastname'),
                'UserEmail' => $order->getCustomerEmail(),
                'UserContact' => $billingAddress->getTelephone(),
                'Remark' => '',
                'Lang' => 'UTF-8',
                'Signature' => $signature,
                'ResponseURL' => $baseUrl.'payment/ipay88/responsecc',
                'BackendURL' => $baseUrl.'payment/ipay88/backendresponsecc'
            ];

            $this->logger->info('parameters: ' . json_encode($result, JSON_PRETTY_PRINT));
        } else {
            $this->logger->info('===== Request block ===== Order NOT Found!');
        }
        $this->logger->info('===== Request block ===== end');

        return $result;
    }

    public function ipay88Signature($source)
    {
        return base64_encode(hex2bin(sha1($source)));
    }
}