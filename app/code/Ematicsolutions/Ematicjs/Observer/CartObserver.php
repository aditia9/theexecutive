<?php

namespace Ematicsolutions\Ematicjs\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

use \Ematicsolutions\Ematicjs\Helper\Data;

class CartObserver implements ObserverInterface
{

  public function __construct()
  {
    
  }

  public function execute(\Magento\Framework\Event\Observer $observer)
  {
    
    if (Data::getLogMode() != Data::MOD_CONVERT) {
        Data::setCartUpdated();
        
        if ($product = $observer->getEvent()->getData('product')) {
          $_SESSION[Data::PRODUCT_KEY] = $product->getId();
        } 
    }
      
  }
}