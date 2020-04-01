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
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Framework\Message\ManagerInterface;
use \Hypework\Payment\Helper\Data as HypeworkPaymentData;

class ResponseCc extends \Magento\Framework\App\Action\Action
{
    protected $_session;
    protected $_resourceConnection;
    protected $_customer;
    protected $_logger;
    protected $_helperData;
    protected $_resultRedirect;
    protected $_messageManager;

    public function __construct(
        \Hypework\Payment\Logger\Logger $logger,
        \Magento\Framework\App\Action\Context $context,
        Session $session,
        ResourceConnection $resourceConnection,
        CustomerSession $customer,
        HypeworkPaymentData $helperData,
        ResultFactory $result,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        date_default_timezone_set('Asia/Jakarta');

        $this->_logger = $logger;
        $this->_session = $session;
        $this->_resourceConnection = $resourceConnection;
        $this->_customer = $customer->getCustomer();
        $this->_helperData = $helperData;
        $this->_resultRedirect = $result;
        $this->_messageManager = $messageManager;
    }

    public function execute()
    {
        $this->_logger->info('===== Ipay88-Response Controller ===== Start ');
        $this->_logger->debug(json_encode($_POST));

        if ($this->_helperData->validateData($_POST)) {
            $this->_messageManager->addSuccessMessage("Payment with Credit Card successfully");
            $resultRedirect = $this->_resultRedirect->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/onepage/success');
        } else {
            $this->_logger->info('===== Ipay88-Response Error: '.@$_POST['ErrDesc']);
            $resultRedirect = $this->_resultRedirect->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/onepage/failure');
            $this->_messageManager->addErrorMessage('Payment with Credit Card failed. Reason: '.@$_POST['ErrDesc']);
        }
        $this->_logger->info('===== Ipay88-Response Controller ===== End');

        return $resultRedirect;
    }
}
