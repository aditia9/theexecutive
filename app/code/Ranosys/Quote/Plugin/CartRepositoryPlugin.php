<?php

namespace Ranosys\Quote\Plugin;


class CartRepositoryPlugin {
    
    protected $couponBlock;
    
    protected $state;
    
    protected $salesruleFactory;
    
    protected $couponFactory;
    
    protected $quoteRepository;
    
    protected $request;
    
    public function __construct(
        \Magento\Checkout\Block\Cart\Coupon $couponBlock,
        \Magento\Framework\App\State $state,
        \Ranosys\SalesRule\Model\SalesRuleFactory $salesruleFactory,
        \Magento\SalesRule\Model\CouponFactory $couponFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->couponBlock = $couponBlock;
        $this->state = $state;
        $this->salesruleFactory = $salesruleFactory;
        $this->couponFactory = $couponFactory;
        $this->quoteRepository = $quoteRepository;
        $this->request = $request;
    }
    
    public function afterGetActive(\Magento\Quote\Api\CartRepositoryInterface $quoteRepository, $quote, $cartId){
        $currentState = $this->state->getAreaCode();
        
        $couponCode = $quote->getCouponCode();
        
        $isMobileRequest = $this->request->getParam('from_mobile');
        
        if(!$couponCode){
            return $quote;
        }
        
        $ruleId = $this->couponFactory->create()->loadByCode($couponCode)->getRuleId();
        
        $model = $this->salesruleFactory->create();
        $modelUpdate = $model->getCollection()->addFieldToFilter('rule_id',$ruleId)->getData();
        
        if(empty($modelUpdate)){
            return $quote;
        }
        
        $areacode = $modelUpdate[0]['area_code'];
        if($currentState =="frontend" && $areacode == "2"){
            $this->quoteRepository->save($quote->setCouponCode('')->collectTotals());
        }
        elseif (($currentState =="webapi_rest" || $currentState =="webapi_soap") && ($isMobileRequest != NULL) && $areacode == "1") {
            $this->quoteRepository->save($quote->setCouponCode('')->collectTotals());
        }
        
        return $quote;
    }
    
}