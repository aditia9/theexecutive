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
use \Magento\Sales\Model\Service\InvoiceService;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface;
use \Magento\Sales\Model\Order;
use \Hypework\Payment\Helper\Data as HypeworkPaymentData;

class TransactionPayment extends \Magento\Framework\App\Action\Action
{
    protected $_session;
    protected $_resourceConnection;
    protected $_customer;
    protected $_logger;
    protected $_helperData;
    protected $_resultRedirect;
    protected $_messageManager;
    protected $_order;
    protected $_invoiceService;
    protected $_scopeConfig;
    protected $_builderInterface;

    //protected $_prefixTrans = '00';
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
        Order $order,
        ScopeConfigInterface $scopeConfig,
        InvoiceService $invoiceService,
        BuilderInterface $builderInterface
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
        $this->_order = $order;
        $this->_builderInterface = $builderInterface;
        $this->_invoiceService = $invoiceService;
    }

    public function execute()
    {
        $this->_logger->info('===== START TransactionPayment Controller ===== Start ');
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
            $vaNumber   = $array['accountNo'];
            $signature  = strtoupper($array['signature']);
            $amount     = (string)$array['amount'].".00";
            $feeAmount  = (string)$array['feeAmount'].".00";
            $netAmount  = (string)$array['netAmount'].".00";
            $transDate  = $array['transDate'];
            $traceNo    = $array['traceNo'];

            $query = $connection->query(
                sprintf("SELECT * FROM hypework_prismalink_va WHERE account_no='%s' LIMIT 1", $vaNumber)
            );
            $results = $query->fetch();
            if (isset($results['increment_id'])) {
                $order = $om->create('Magento\Sales\Model\Order')->loadByIncrementId($results['increment_id']);
                $mySignature = strtoupper(md5(
                    $partnerId . $vaNumber . $amount . $feeAmount . $netAmount . $transDate . $traceNo .$sharedKey
                ));
                //MD5(partnerId+accountNo+amount+fee Amount+netAmount+transDate+traceNo +sharedKey)
                //  "4e36d57e-1436-4b1a-89a4-88cab5f52872" . "7980100000005400". 244300 . 2500 . 241800 . "20180416171107" .  "201804161710459712" . "5c7f510a8fae1c1f45c3b97a
                if ($signature != $mySignature) {
                    $this->_logger->info('===== TransactionPayment Controller - Signature NOT VALID => '.$signature.'/'.$mySignature.'=====');
                    return;
                } else {
                    $this->_logger->info('===== TransactionPayment Controller - Signature VALID => '.$signature.'/'.$mySignature.'=====');
                }

                $response = [
                    'responseCode' => '00',
                    'responseMessage' => 'success',
                    'customerUsername' => $order->getCustomerName(),
                    'customerEmail' => $order->getCustomerEmail()
                ];
                // create invoice
                if ($order->canInvoice() && !$order->hasInvoices()) {
                    $invoice = $this->_invoiceService->prepareInvoice($order);
                    $invoice->register();
                    $invoice->pay();
                    $invoice->save();
                    $transactionSave = $om->create(
                        'Magento\Framework\DB\Transaction'
                    )->addObject(
                        $invoice
                    )->addObject(
                        $invoice->getOrder()
                    );
                    $transactionSave->save();

                    $payment = $order->getPayment();
                    $payment->setLastTransactionId($order->getIncrementId());
                    $payment->setTransactionId($order->getIncrementId());
                    $payment->setAdditionalInformation([\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS => $array]);
                    $trans = $this->_builderInterface;
                    $transaction = $trans->setPayment($payment)
                        ->setOrder($order)
                        ->setTransactionId($order->getIncrementId())
                        ->setAdditionalInformation([\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS => $array])
                        ->setFailSafe(true)
                        ->build(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_CAPTURE);
                    $payment->addTransactionCommentsToOrder($transaction, json_encode($array, JSON_PRETTY_PRINT));
                    $payment->save();
                    $transaction->save();

                    if ($invoice && !$invoice->getEmailSent()) {
                        $invoiceSender = $om->get('Magento\Sales\Model\Order\Email\Sender\InvoiceSender');
                        $invoiceSender->send($invoice);
                        $order->addRelatedObject($invoice);
                        $order->addStatusHistoryComment(__('Your Invoice for Order ID #%1.', $order->getIncrementId()))
                            ->setIsCustomerNotified(true);
                    }
                    $order->setData('state', 'processing');
                    $order->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING);
                    $order->addStatusHistoryComment('Approved by Prismalink.', \Magento\Sales\Model\Order::STATE_PROCESSING);
                    $order->save();
                    // e:update status

                    $this->_logger->info('===== TransactionPayment create invoice success =====');
                    $sql = sprintf("UPDATE hypework_prismalink_va SET status = 'SUCCESS' WHERE account_no='%s' LIMIT 1", $vaNumber);
                    $connection->query($sql);
                }

                $this->_logger->info('===== TransactionPayment Controller '.$order->getIncrementId().' =====');
            } else {
                $response = [
                    'responseCode' => '01',
                    'responseMessage' => 'failed order_id or signature  not found',
                    'customerUsername' => 'none'
                ];
                $this->_logger->info('===== TransactionPayment Controller - failed order_id or signature not found =====');
            }
        } else {
            $response = [
                'responseCode' => '01',
                'responseMessage' => 'no accountNo in our database',
                'customerUsername' => 'none'
            ];
            $this->_logger->info('===== TransactionPayment Controller - no accountNo in our database =====');
        }

        $responseJson = json_encode($response);
        $this->_logger->debug($responseJson);
        $this->_logger->info('===== EOF TransactionPayment Controller =====');
        // response
        echo $responseJson;
        exit;
    }
}
