<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/22/18
 * Time: 1:50 AM
 */
namespace Hypework\Payment\Controller\Prismalink;

use \Magento\Checkout\Model\Session;
use \Magento\Framework\App\ResourceConnection;
use \Magento\Customer\Model\Session as CustomerSession;
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Framework\Message\ManagerInterface;
use \Hypework\Payment\Helper\Data as HypeworkPaymentData;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class TransactionInquiry extends \Magento\Framework\App\Action\Action
{
    protected $_session;
    protected $_resourceConnection;
    protected $_customer;
    protected $_logger;
    protected $_helperData;
    protected $_resultRedirect;
    protected $_messageManager;
    protected $_scopeConfig;
    //protected $_partnerId = '4e36d57e-1436-4b1a-89a4-88cab5f52872';
    //protected $_shareKey = '5c7f510a8fae1c1f45c3b97a';

    public function __construct(
        \Hypework\Payment\Logger\Logger $logger,
        \Magento\Framework\App\Action\Context $context,
        Session $session,
        ResourceConnection $resourceConnection,
        CustomerSession $customer,
        HypeworkPaymentData $helperData,
        ResultFactory $result,
        ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig
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
        $this->_scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $this->_logger->info('===== START TransactionInquiryRequest Controller =====');
        $om = \Magento\Framework\App\ObjectManager::getInstance();

        $json = file_get_contents('php://input');
        $this->_logger->debug($json);

        $array = json_decode($json, true);
        $connection = $this->_resourceConnection->getConnection();

        $partnerId      = $this->_scopeConfig->getValue('payment/prismalink_vabca/partner_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $sharedKey      = $this->_scopeConfig->getValue('payment/prismalink_vabca/shared_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        //$prefixbin      = $this->_scopeConfig->getValue('payment/prismalink_vabca/prefix_bin', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        //$prefixtrans    = $this->_scopeConfig->getValue('payment/prismalink_vabca/prefix_trans', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        // request from prismalink
        if (isset($array['accountNo'])) {
            $vaNumber = $array['accountNo'];
            $signature = strtoupper($array['signature']);
            $query = $connection->query(
                sprintf("SELECT * FROM hypework_prismalink_va WHERE account_no='%s' AND status='PENDING' LIMIT 1", $vaNumber)
            );
            $results = $query->fetch();
            if (isset($results['increment_id'])) {
                $order = $om->create('Magento\Sales\Model\Order')->loadByIncrementId($results['increment_id']);
                $mySignature = strtoupper(md5($partnerId . $vaNumber . $sharedKey));
                if ($signature != $mySignature) {
                    $this->_logger->info('===== TransactionInquiry Controller - Signature NOT VALID => '.$signature.'/'.$mySignature.'=====');
                    return;
                } else {
                    $this->_logger->info('===== TransactionInquiry Controller - Signature VALID => '.$signature.'/'.$mySignature.'=====');
                }

                $response = [
                    'vaName' => 'VA BCA',
                    'responseCode' => '00',
                    'responseMessage' => 'success',
                    'billingAmount' => str_replace('.0000', '', $order->getGrandTotal())
                ];
                $sql = sprintf("UPDATE hypework_prismalink_va SET is_inquiry = '1' WHERE account_no='%s' LIMIT 1", $vaNumber);
                $connection->query($sql);
                $this->_logger->info('===== TransactionInquiry Controller - success inquiry - '.$order->getIncrementId().' =====');
            } else {
                $order = $om->create('Magento\Sales\Model\Order')->loadByIncrementId($results['increment_id']);
                $response = [
                    'vaName' => 'VA BCA',
                    'responseCode' => '01',
                    'responseMessage' => 'failed order_id or signature  not found',
                    'billingAmount' => str_replace('.0000', '', $order->getGrandTotal())
                ];
                $this->_logger->info('===== TransactionInquiry Controller - failed order_id or signature not found =====');
            }

        } else {
            $response = [
                'vaName' => 'NONE',
                'responseCode' => '01',
                'responseMessage' => 'no accountNo in our database',
                'billingAmount' => '0'
            ];
            $this->_logger->info('===== TransactionInquiry Controller - no accountNo in our database =====');
        }

        $responseJson = json_encode($response);
        $this->_logger->debug($responseJson);
        $this->_logger->info('===== EOF TransactionInquiry Controller =====');
        // response
        echo $responseJson;
        exit;
    }
}
