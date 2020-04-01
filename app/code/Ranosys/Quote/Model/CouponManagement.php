<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ranosys\Quote\Model;

use \Magento\Quote\Api\CouponManagementInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Coupon management object.
 */
class CouponManagement extends \Magento\Quote\Model\CouponManagement
{
    
    protected $salesruleFactory;
    
    protected $coupon;
    
    protected $request;
    
    protected $state;

    /**
     * Constructs a coupon read service object.
     *
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository Quote repository.
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Ranosys\SalesRule\Model\SalesRuleFactory $salesruleFactory,
        \Magento\SalesRule\Model\Coupon $coupon,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\State $state
    ) {
        parent::__construct($quoteRepository);
        $this->salesruleFactory = $salesruleFactory;
        $this->coupon = $coupon;
        $this->request = $request;
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function set($cartId, $couponCode)
    {
        $currentState = $this->state->getAreaCode();
        
        $currentRequest = $this->request->getParams();  
        $isMobileRequest = NULL;
        if(isset($currentRequest['from_mobile'])){
            $isMobileRequest = $currentRequest['from_mobile'];
        }
        $ruleId = $this->coupon->loadByCode($couponCode)->getRuleId();
        $model = $this->salesruleFactory->create();
        $modelUpdate = $model->getCollection()->addFieldToFilter('rule_id',$ruleId)->getData();
        if(!empty($modelUpdate))
        {
            $areacode = $modelUpdate[0]['area_code'];
        }
        else
        {
           $areacode = 0; 
        }
        if(($isMobileRequest == '1' && ($areacode == "0" || $areacode == "2" )) || ($isMobileRequest == null && ($areacode == "0" || $areacode == "1" )))
        {
            /** @var  \Magento\Quote\Model\Quote $quote */
            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }
            $quote->getShippingAddress()->setCollectShippingRates(true);

            try {
                $quote->setCouponCode($couponCode);
                $this->quoteRepository->save($quote->collectTotals());
            } catch (\Exception $e) {
                throw new CouldNotSaveException(__('Could not apply coupon code'));
            }
            if ($quote->getCouponCode() != $couponCode) {
                throw new NoSuchEntityException(__('Coupon code is not valid'));
            }
            return true;
        } 
        else
        {
            throw new CouldNotSaveException(__('Could not apply coupon code'));
        }
    }
}
