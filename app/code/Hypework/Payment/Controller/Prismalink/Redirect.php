<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/22/18
 * Time: 1:44 AM
 */
namespace Hypework\Payment\Controller\Prismalink;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Mail\Template\TransportBuilder;

class Redirect extends \Magento\Framework\App\Action\Action
{
    protected $_session;
    protected $_resourceConnection;
    protected $_customer;
    protected $_logger;
    protected $_storeManager;
    protected $_pageFactory;
    protected $_scopeConfig;
    protected $_dataObject;
    protected $_transportBuilder;
    //protected $_prefixTrans = '00';
    //protected $_binNumber = '79801';

    public function __construct(
        \Hypework\Payment\Logger\Logger $logger,
        Context $context,
        Session $session,
        ResourceConnection $resourceConnection,
        CustomerSession $customer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        ResultFactory $result,
        ScopeConfigInterface $scopeConfig,
        DataObject $dataObject,
        TransportBuilder $transportBuilder
    ) {
        parent::__construct($context);
        date_default_timezone_set('Asia/Jakarta');

        $this->_logger = $logger;
        $this->_session = $session;
        $this->_resourceConnection = $resourceConnection;
        $this->_customer = $customer->getCustomer();
        $this->_storeManager = $storeManager;
        $this->_pageFactory = $pageFactory;
        $this->_resultRedirect = $result;
        $this->_scopeConfig = $scopeConfig;
        $this->_dataObject = $dataObject;
        $this->_transportBuilder = $transportBuilder;
    }

    public function execute()
    {
        $order = $this->_session->getLastRealOrder();
        if ($order->getId() && (!$order->hasInvoices() || !$order->hasShipments())) {
            $query = $this->_resourceConnection->getConnection()->query(
                sprintf("SELECT * FROM hypework_prismalink_va WHERE order_id='%s' AND store_id='%s' LIMIT 1", $order->getId(), $order->getStoreId())
            );
            $resultOrder = $query->fetch();
            $paymentCode = @$order->getPayment()->getMethodInstance()->getCode();

            if (is_null($paymentCode)) {
                $this->_logger->info('===== redirectPrismalink NULL =====');
                return;
            }

            if ($paymentCode == 'prismalink_vabca') {
                // send email
                $sender = array('email' => "cs_online@delamibrands.com", 'name' => 'CS Online The Executive'); 
                $storeName = $this->_scopeConfig->getValue('general/store_information/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                $emailVar = [
                    'subject' => $storeName . " #". $resultOrder['increment_id']. " - Virtual Account BCA",
                    'customerName' => $order->getCustomerName(),
                    'storeName' => $order->getStoreName(),
                    'invoiceNo' => $resultOrder['increment_id'],
                    'vaNumber' => $resultOrder['account_no'],
                    'amount' => number_format(substr($order->getGrandTotal(), 0, -4), 2, ",", "."),
                ];
                $this->_dataObject->setData($emailVar);
                $this->_transportBuilder
                    ->setTemplateIdentifier('vanumber_template_bca')
                    ->setTemplateOptions([
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $order->getStoreId()
                    ])
                    ->setTemplateVars(['data' => $this->_dataObject])
                    ->setFrom($sender)
                    ->addTo($order->getCustomerEmail(), $order->getCustomerName());
                $transport = $this->_transportBuilder->getTransport();
                $transport->sendMessage();
                $resultRedirect = $this->_resultRedirect->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/onepage/success');
            }
        } else {
            $resultRedirect = $this->_resultRedirect->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/onepage/failure');
        }

        return $resultRedirect;
    }
}