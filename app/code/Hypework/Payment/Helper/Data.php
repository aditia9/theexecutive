<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/10/18
 * Time: 11:37 PM
 */
namespace Hypework\Payment\Helper;

use \Magento\Sales\Model\Service\InvoiceService;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface;
use \Magento\Sales\Model\Order;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_order;
    protected $_scopeConfig;
    protected $_builderInterface;
    protected $_invoiceService;
    public $_currency = 'IDR';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Order $order,
        ScopeConfigInterface $scopeConfig,
        InvoiceService $invoiceService,
        BuilderInterface $builderInterface
    ) {
        parent::__construct($context);
        $this->_scopeConfig = $scopeConfig;
        $this->_order = $order;
        $this->_builderInterface = $builderInterface;
        $this->_invoiceService = $invoiceService;
    }

    public function validateData($post, $validateOnly = true)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $this->_order->loadByIncrementId($post['RefNo']);
        $paymentcode = $order->getPayment()->getMethodInstance()->getCode();
        $merchantkey = $this->_scopeConfig->getValue('payment/' . $paymentcode . '/merchant_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $merchantcode = $this->_scopeConfig->getValue('payment/' . $paymentcode . '/merchant_code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $refno = $order->getIncrementId();
        $amount = str_replace('.0000', '', $order->getGrandTotal()) . '00';
        $currency = $this->_currency;
        $status = $post['Status'];
        $paymentid = '1';
        $source = $merchantkey . $merchantcode . $paymentid . $refno . $amount . $currency . $status;
        $signature = $this->ipay88Signature($source);

        $this->_logger->info('===== Ipay88-Cc validateData ===== Start');
        $this->_logger->debug(json_encode([
            'source' => $source,
            'signature' => $signature,
            'PostSignature' => $post['Signature'],
            'post' => $post
        ]));
        if ($post['Signature'] == $signature) {
            // validate only
            if ($validateOnly) {
                if ($post['Status'] == 1) {
                    return true;
                } else {
                    $order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                    $order->setStatus(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
                    $order->save();
                    if ($order->canCancel()) {
                        $order->cancel();
                        $order->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED);
                        $order->setState(\Magento\Sales\Model\Order::STATE_CANCELED);
                        if (isset($post['ErrDesc']) && !empty($post['ErrDesc'])) {
                            $comment = __('Canceled By Ipay88 with message ' . @$post['ErrDesc']);
                        } else {
                            $comment = __('Canceled By Ipay88.');
                        }
                        $order->addStatusHistoryComment($comment);
                        $order->save();
                    }
                    return false;
                }
            } else {
                // validate with create invoice or cancel
                if ($post['Status'] == 1) {
                    // create invoice
                    if ($order->canInvoice() && !$order->hasInvoices()) {
                        $invoice = $this->_invoiceService->prepareInvoice($order);
                        $invoice->register();
                        $invoice->pay();
                        $invoice->save();
                        $transactionSave = $objectManager->create(
                            'Magento\Framework\DB\Transaction'
                        )->addObject(
                            $invoice
                        )->addObject(
                            $invoice->getOrder()
                        );
                        $transactionSave->save();

                        $payment = $order->getPayment();
                        $payment->setLastTransactionId($post['RefNo']);
                        $payment->setTransactionId($post['RefNo']);
                        $payment->setAdditionalInformation([\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS => (array) $post]);
                        $trans = $this->_builderInterface;
                        $transaction = $trans->setPayment($payment)
                            ->setOrder($order)
                            ->setTransactionId($post['RefNo'])
                            ->setAdditionalInformation([\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS => (array) $post])
                            ->setFailSafe(true)
                            ->build(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_CAPTURE);
                        $payment->addTransactionCommentsToOrder($transaction, json_encode($post, JSON_PRETTY_PRINT));
                        $payment->save();
                        $transaction->save();

                        if ($invoice && !$invoice->getEmailSent()) {
                            $invoiceSender = $objectManager->get('Magento\Sales\Model\Order\Email\Sender\InvoiceSender');
                            $invoiceSender->send($invoice);
                            $order->addRelatedObject($invoice);
                            $order->addStatusHistoryComment(__('Your Invoice for Order ID #%1.', @$post['RefNo']))
                                ->setIsCustomerNotified(true);
                        }

                        // s:update status
                        /*$order->addStatusToHistory(\Magento\Sales\Model\Order::STATE_PROCESSING);
                        $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING);
                        $order->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING);
                        $order->addStatusHistoryComment(__('Approved by Ipay88.'));
                        $order->sendNewOrderEmail();
                        $order->setEmailSent(true);
                        $order->save();*/

                        $order->setData('state', 'processing');
                        $order->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING);
                        $order->addStatusHistoryComment('Approved by iPay88.', \Magento\Sales\Model\Order::STATE_PROCESSING);
                        $order->save();
                        // e:update status

                        $this->_logger->info('===== Ipay88-Cc validateData : Approved ===== End');
                        return true;
                    }
                } else {
                    // not valid. cancel it
                    //if ($order->canCancel()) {
                    $order->cancel();
                    $order->setState(\Magento\Sales\Model\Order::STATE_CANCELED);
                    $order->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED);
                    $comment = __('Canceled By Ipay88 with message ' . @$post['ErrDesc']);
                    $order->addStatusHistoryComment($comment);
                    $order->save();
                    //}

                    $this->_logger->info('===== Ipay88-Cc validateData : Canceled ===== End');
                    return false;
                }
            }
        } else {
            // cancel
            //if ($order->canCancel()) {
                $order->cancel();
                $order->setState(\Magento\Sales\Model\Order::STATE_CANCELED);
                $order->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED);
                $comment = __('Canceled By System signature not valid. ' . @$post['ErrDesc']);
                $order->addStatusHistoryComment($comment);
                $order->save();

                $this->_logger->info('===== Ipay88-Cc validateData : Signature not valid ===== End');
                return false;
            //}
        }
    }

    private function ipay88Signature($source)
    {
        return base64_encode(hex2bin(sha1($source)));
    }
}