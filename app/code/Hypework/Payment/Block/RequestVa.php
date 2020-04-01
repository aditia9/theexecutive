<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 4/7/18
 * Time: 3:52 PM
 */
namespace Hypework\Payment\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Sales\Model\Order;
use \Magento\Checkout\Model\Session;
use \Magento\Framework\App\ResourceConnection;
use \Magento\Framework\App\Request\Http;
use \Hypework\Payment\Model\PaymentGatewayConfigProvider;
use \Hypework\Payment\Helper\Data;

class RequestVa extends \Magento\Framework\View\Element\Template
{
    protected $session;
    protected $order;
    protected $logger;
    protected $resourceConnection;
    protected $config;
    protected $helper;
    protected $request;

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

    public function getFormData()
    {
        /*
        $incrementId = $_SESSION['checkout']['last_real_order_id'];
        $orderId = $_SESSION['checkout']['last_order_id'];
        $result = [];
        return $result;
        */
    }
}