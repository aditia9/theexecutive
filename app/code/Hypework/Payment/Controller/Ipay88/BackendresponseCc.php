<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/10/18
 * Time: 8:35 PM
 */
namespace Hypework\Payment\Controller\Ipay88;

use \Magento\Checkout\Model\Session;
use \Magento\Framework\App\ResourceConnection;
use \Magento\Customer\Model\Session as CustomerSession;
class BackendresponseCc extends \Magento\Framework\App\Action\Action
{
    protected $_session;
    protected $_resourceConnection;
    protected $_customer;
    protected $_logger;
    protected $_helperData;

    private $_urlSandbox = 'https://sandbox.ipay88.co.id/epayment/entry.asp';
    // private $_urlSandbox = 'https://payment.ipay88.co.id/epayment/entry.asp';

    public function __construct(
        \Hypework\Payment\Logger\Logger $logger,
        \Magento\Framework\App\Action\Context $context,
        Session $session,
        ResourceConnection $resourceConnection,
        CustomerSession $customer,
        \Hypework\Payment\Helper\Data $helperData

    ) {
        parent::__construct($context);
        date_default_timezone_set('Asia/Jakarta');

        $this->_logger = $logger;
        $this->_session = $session;
        $this->_resourceConnection = $resourceConnection;
        $this->_customer = $customer->getCustomer();
        $this->_helperData = $helperData;
    }

    public function execute()
    {
        if ($this->_helperData->validateData($_POST, false)) {
            $this->_logger->info('Start BackendresponseCc success');
            $this->_logger->debug(json_encode($_POST, JSON_PRETTY_PRINT));
            $this->_logger->info('End BackendresponseCc success');
            echo 'RECEIVEOK';
            return;
        } else {
            $this->_logger->info('Start BackendresponseCc failed');
            $this->_logger->debug(json_encode($_POST, JSON_PRETTY_PRINT));
            $this->_logger->info('End BackendresponseCc failed');
            echo 'DECLINED';
        }
    }
}
