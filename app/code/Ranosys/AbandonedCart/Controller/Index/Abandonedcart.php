<?php

namespace Ranosys\AbandonedCart\Controller\Index;

class Abandonedcart extends \Magento\Framework\App\Action\Action {

    protected $cart;
    protected $scopeConfig;
    protected $timezone;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;
    
    protected $abandonedCartMailFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    protected $eventManager;

    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
            \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
            \Magento\Checkout\Model\Cart $cart, 
            \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
            \Magento\Store\Model\StoreManagerInterface $storeManager,
            \Ranosys\AbandonedCart\Model\AbandonedCartMail $abandonedCartMailFactory
    ) {
        parent::__construct($context);
        $this->cart = $cart;
        $this->timezone = $timezone;
        $this->scopeConfig = $scopeConfig;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->abandonedCartMailFactory = $abandonedCartMailFactory;
        $this->eventManager = $context->getEventManager();
    }

    public function execute() {
//        $cron_enable = $this->scopeConfig->getValue('abandonedcart/email_cron/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//        if ($cron_enable != 1) {
//            return;
//        }

        $abandonedCartMailTimestamp = $this->scopeConfig->getValue('abandonedcart/general/abandonedcart_timestamp', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $cartClearTimestamp = $this->scopeConfig->getValue('abandonedcart/general/abandonedcart_expiration', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        $current_date = $this->timezone->gmtDate();
        
        $to_time = strtotime($current_date);
        $to_time = $to_time - ($abandonedCartMailTimestamp * 60);
        $toDate = date("Y-m-d H:i:s", $to_time);
        
        $from_time = strtotime($current_date);
        $from_time = $from_time - ($cartClearTimestamp * 60);
        $fromDate = date("Y-m-d H:i:s", $from_time);
        
        $store = $this->storeManager->getStore()->getId();
        $templateId = $this->scopeConfig->getValue('abandonedcart/general/abandonedcart_reminder_template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $customers = $this->cart->getQuote()->getCollection()
                ->addFieldToFilter('customer_is_guest', 0)
                ->addFieldToFilter('is_active', 1)
                ->addFieldToFilter('customer_id', array('neq' => 'NULL'))
                ->addFieldToFilter('items_count', array('gt' => 0))
                ->addFieldToFilter('updated_at', array('lteq' => $toDate))
                ->addFieldToFilter('updated_at', array('gteq' => $fromDate));

        foreach ($customers as $customer) {

            $cart_id = $customer->getEntityId();
            $updated_at = $customer->getUpdatedAt();
            $updated_date = strtotime($updated_at);
            $abandonedCartMailCollection = $this->abandonedCartMailFactory->getCollection()
                    ->addFieldToFilter('cart_id', array('eq' => $cart_id));

            $data = $abandonedCartMailCollection->getData();
            if (!empty($data)) {
                $sent_at = $data[0]['sent_at'];
                $sentAt = strtotime($sent_at);
            }


            if (empty($data) || ($updated_date > $sentAt)) {
                $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
                        ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
                        ->setTemplateVars(
                                [
                                    'store' => $this->storeManager->getStore(),
                                ]
                        )
                        ->setFrom('general')
                        ->addTo($customer->getCustomerEmail(), $customer->getCustomerFirstname())
                        ->getTransport();
                $transport->sendMessage();
                if (empty($data)) {
                    $this->abandonedCartMailFactory->setData(
                            ['cart_id' => $cart_id,
                             'sent_at' => $current_date]);
                    $this->abandonedCartMailFactory->save();
                } else {
                    foreach ($abandonedCartMailCollection as $item) {
                        $item->setSentAt($current_date);
                        $item->save();
                    }
                }

                $this->eventManager->dispatch('abandonedcart_sendmail_after', ['order' => $customer]);
            }
        }
    }

}


