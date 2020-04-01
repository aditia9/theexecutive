<?php
namespace Ranosys\Notification\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }
    
    /**
     * check notification can be send according to order state/status
     * 
     * @param \Magento\Sales\Model\Order $order
     * @return boolean
     */
    public function isOrderNotifiable($order) {
        //status on which to send mobile app notifications
        $notificationStatus = [
            'payment_confirmation',
            'paymentconfirmationreceive',
            'preperation_in_progress',
            'closed',
            'canceled',
            'complete',
        ];
        $status = $order->getStatus();
        
        if(in_array($status, $notificationStatus)){
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Get order notification message according to state/status
     * @param type $order
     */
    public function getOrderNotificationMessage($order){
        $status = $order->getStatus();
        switch ($status):
            case 'payment_confirmation':
                $message = __('Payment Confirmation for your order #%1 was successfull.', $order->getIncrementId());
                break;
            case 'paymentconfirmationreceive':
                $message = __('Payment Confirmation for your order #%1 has been successfully received.', $order->getIncrementId());
                break;
            case 'preperation_in_progress':
                $message = __('Your order #%1 is being prepared.', $order->getIncrementId());
                break;
            case 'canceled':
                $message = __('Your order #%1 has been canceled.', $order->getIncrementId());
                break;
            case 'complete':
                $message = __('Your order #%1 has been delivered successfully.', $order->getIncrementId());
                break;
            case 'closed':
                $message = __('Your order #%1 has been returned.', $order->getIncrementId());
        endswitch;
        
        return $message;
    }
    
}