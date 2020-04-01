<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/10/18
 * Time: 8:35 PM
 * entry url sandbox: https://sandbox.ipay88.co.id/epayment/entry.asp
 */
namespace Hypework\Payment\Controller\Ipay88;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\ResourceConnection;
use \Magento\Customer\Model\Session as CustomerSession;

class RequestCc extends \Magento\Framework\App\Action\Action
{
    protected $_session;
    protected $_resourceConnection;
    protected $_customer;
    protected $_logger;
    protected $_storeManager;
    protected $_pageFactory;

    public function __construct(
        \Hypework\Payment\Logger\Logger $logger,
        \Magento\Framework\App\Action\Context $context,
        Session $session,
        ResourceConnection $resourceConnection,
        CustomerSession $customer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        parent::__construct($context);
        date_default_timezone_set('Asia/Jakarta');

        $this->_logger = $logger;
        $this->_session = $session;
        $this->_resourceConnection = $resourceConnection;
        $this->_customer = $customer->getCustomer();
        $this->_storeManager = $storeManager;
        $this->_pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
