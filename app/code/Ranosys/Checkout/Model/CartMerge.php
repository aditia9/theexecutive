<?php

namespace Ranosys\Checkout\Model;

use \Magento\Framework\Exception\LocalizedException;

class CartMerge implements \Ranosys\Checkout\Api\CartMergeInterface {
    
    protected $customerSession;
    
    protected $checkoutSession;
    
    protected $customerFactory;
    
    protected $quoteIdMaskFactory;
    
    protected $request;
    
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->customerFactory = $customerFactory;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
    }
    
    /**
     * {@inheritdoc}
     */
    public function mergeCart($customerId, $guestCartId) {
        try{
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($guestCartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
            
            if(!$cartId){
                throw new LocalizedException(__('Invalid guest cart id.'));
            }

            $customer = $this->customerFactory->create()->load($customerId);
            $this->customerSession->setCustomer($customer);

            $this->checkoutSession->setQuoteId($cartId);

            $this->checkoutSession->loadCustomerQuote();
            
            return sprintf('%s', __('Cart merged successfully.'));
        } catch(\Exception $e){
            return sprintf('%s', __('Error merging cart. %1', $e->getMessage()));
        }
          
    }
    
}