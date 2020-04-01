<?php

namespace Ematicsolutions\Ematicjs\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

use \Ematicsolutions\Ematicjs\Helper\Data;

class ConversionObserver implements ObserverInterface
{

  private $helper;

  public function __construct(Data $helper)
  {
    $this->helper = $helper;
  }

  public function execute(\Magento\Framework\Event\Observer $observer)
  {
      
      $_SESSION[Data::LOG_MODE] = Data::MOD_CONVERT; //set log mode

      $transId = '';
      $order = $observer->getEvent()->getOrder();
      
      //Find transaction id
      if ($payment = $order->getPayment()) {

        $transId = $payment->getLastTransId();

        if (!$transId) {
          $transId = $payment->getTransactionId();
        }

      }

      //Store transactionId
      $_SESSION[Data::TRANSACTION_KEY] = $transId;

      //Store data
      $_SESSION[Data::CART_KEY_PRODUCTS] = $this->helper->getProductsInOrder($order);
  }
}