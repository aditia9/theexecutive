<?php

namespace Ranosys\AbandonedCart\Cron;

class ClearAbandonedcart {

    protected $cart;
    protected $scopeConfig;
    protected $timezone;

    public function __construct(
            \Magento\Framework\App\Action\Context $context, 
            \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
            \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
            \Magento\Checkout\Model\Cart $cart
    ) {
        parent::__construct($context);
        $this->cart = $cart;
        $this->timezone = $timezone;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute() {

        $cron_enable = $this->scopeConfig->getValue('abandonedcart/clearcart_cron/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($cron_enable != 1) {
            return;
        }
        $expiration = $this->scopeConfig->getValue('abandonedcart/general/abandonedcart_expiration', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $cur_date = $this->timezone->gmtDate();
        $to_time = strtotime($cur_date);
        $to_time = $to_time - ($expiration * 60);
        $cur_date = date("Y-m-d H:i:s", $to_time);

        $customers = $this->cart->getQuote()->getCollection()
                ->addFieldToFilter('customer_is_guest', 0)
                ->addFieldToFilter('is_active', 1)
                ->addFieldToFilter('customer_id', array('neq' => 'NULL'))
                ->addFieldToFilter('updated_at', array('lteq' => $cur_date));

        foreach ($customers as $customer) {

            $allItems = $customer->getItemsCollection();

            foreach ($allItems as $item) {
                $itemId = $item->getItemId();
                $quoteItem = $customer->load($itemId);
                $quoteItem->delete()->save();
            }
        }
    }

}
