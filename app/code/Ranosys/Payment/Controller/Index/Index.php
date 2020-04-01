<?php

namespace Ranosys\Payment\Controller\Index;

use Magento\Framework\Exception\NotFoundException;
use Hypework\Payment\Model\Payment\PrismalinkVabca;
use Hypework\Payment\Model\Payment\Ipay88Cc;
use Magento\Integration\Model\Oauth\TokenFactory;

class Index extends \Magento\Framework\App\Action\Action {
    
    protected $orderRepository;
    
    protected $checkoutSession;
    
    protected $prismaLinkVabca;
    
    protected $ipay;
    
    protected $tokenFactory;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,    
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        PrismalinkVabca $prismaLinkVabca,
        TokenFactory $tokenFactory,
        Ipay88Cc $ipay
    ) {
        parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
        $this->prismaLinkVabca = $prismaLinkVabca;
        $this->ipay = $ipay;
        $this->tokenFactory = $tokenFactory;
    }
    
    public function execute(){
        $orderid = $this->getRequest()->getParam('orderid');
        $customerToken = $this->getRequest()->getParam('token');
        if(!$orderid || !$customerToken){
            throw new NotFoundException(__('Order not found'));
        }       
        
        try {
            $token = $this->tokenFactory->create()->loadByToken($customerToken);
            $order = $this->orderRepository->get($orderid);    
            
            if(!$token->getId() || ($order->getCustomerId() != $token->getCustomerId())){
                throw new \Exception('Not Authorized');
            }
            
            return $this->_processOrder($order);
        } catch(\Exception $e){
            throw new NotFoundException($e->getMessage());
        }
        
    }
    
    protected function _processOrder($order){
        $paymentCode = $order->getPayment()->getMethodInstance()->getCode();
        $this->checkoutSession->setLastRealOrderId($order->getIncrementId());
        $this->checkoutSession->setLastOrderId($order->getId());
        $this->checkoutSession->setLastRealOrder($order);
        switch($paymentCode):
            case $this->prismaLinkVabca->getCode():
                //return $this->_forward('redirect', 'prismalink', 'payment');
                return $this->_redirect('payment/prismalink/redirect');
                break;
            case $this->ipay->getCode():
                //return $this->_forward('requestCc', 'ipay88', 'payment');
                return $this->_redirect('payment/ipay88/requestCc');
                break;
            default:
                if($this->_orderSuccess()){
                    $this->_redirect('checkout/onepage/success');
                } else {
                    $this->_redirect('checkout/onepage/failure');
                }
        endswitch;
    }
    
    protected function _orderSuccess($order){
        if($order->isCanceled() || $order->getState() == \Magento\Sales\Model\Order::STATE_CLOSED){
            return FALSE;
        }
        
        return TRUE;
    }
    
}