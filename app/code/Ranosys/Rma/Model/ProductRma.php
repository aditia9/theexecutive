<?php

namespace Ranosys\Rma\Model;

use Ranosys\Rma\Api\ProductRmaInterface;
use Magento\Framework\Exception\InputException;

/**
 * Implementation class of contract.
 */
class ProductRma implements ProductRmaInterface 
{

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    protected $_storeManager;
    
    protected $_transportBuilder;
    
    protected $orderobject;
    
    protected $eventManager;
    
    protected $rmaPdf;

    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Sales\Model\Order $orderObject,
        \Magento\Sales\Model\Order\Item $orderItemObject,
        \Magento\Sales\Model\Order\Email\Sender\OrderCommentSender $sendEmail,
        \Ranosys\Rma\Model\Pdf $rmaPdf
    ) {
        $this->sendEmail = $sendEmail;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager=$storeManager;
        $this->_transportBuilder = $transportBuilder;
        $this->orderobject = $orderObject;
        $this->orderItemobject = $orderItemObject;
        $this->eventManager = $context->getEventManager();
        $this->rmaPdf = $rmaPdf;
      } 
    
    
    /**
     * Return array
     *
     * @api
     * @param mixed $rmaData
     * @return string Rma status
     * @throws \Magento\Framework\Exception\InputException
     */
    public function execute($rmaData)
    {
       
        if($rmaData){
            
            try {
                    $recipients = explode(';', $this->_scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/emailrecipients', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
                    $returnedItems = $rmaData['items'];
                    $returnedItemMessage = ''; 
                    $itemsSku = array();
                    $pdfItems = array();
                    foreach($returnedItems as $returnedItem)
                    {
                        $itemId = $returnedItem['item_id'];
                        $orderItems = $this->orderItemobject->load($itemId);
                        $itemName = $orderItems->getName();
                        $itemSku = $orderItems->getSku();
                        $itemsSku[] = $itemSku;
                        $returnedItemMessage .= "[Product Name = " . $itemName. ". Product SKU = ".$itemSku.". Returned Quantity = ".$returnedItem['qty'].". Reason = ".$returnedItem['reason']."]";
                        $productOptions = $orderItems->getProductOptions();
                        $color = '';
                        $size = '';
                        if($productOptions){
                            foreach($productOptions['attributes_info'] as $attribute){
                                if($attribute['label'] == 'Color'){
                                    $color = $attribute['value'];
                                } elseif($attribute['label'] == 'Size'){
                                    $size = $attribute['value'];
                                }
                            }
                        }
                        $pdfItems[] = array(
                            'name' => $orderItems->getName(),
                            'reason' => $returnedItem['reason'],
                            'color' => $color,
                            'size' => $size
                        );
                        
                    }
                    
                    if(isset($rmaData['return_mode'])) {
                        $returnedItemMessage .= " Return Mode = {$rmaData['return_mode']} .\n";
                    }
                    
                    $itemskustring = implode(",",$itemsSku);
                    $orderId = $rmaData['orderId'];
                    $order = $this->orderobject->loadByIncrementId($orderId);
                    $customerName = $order->getCustomerFirstname();
                    $customerEmail = $order->getCustomerEmail();
                    $shippingAddressObj = $order->getShippingAddress()->getData();
                    $customerTelephone = $shippingAddressObj['telephone'];
                    
                    $vars = array(
                        'store' => $this->_storeManager->getStore(),
                        'order_id' => $rmaData['orderId'],
                        'name' => $customerName,
                        'email_submitter' => $customerEmail,
                        'phone' => $customerTelephone,
                        'sku' => $itemskustring,
                        'message' => $returnedItemMessage,
                        'order' => $order
                    );
                    
                    if(isset($rmaData['return_mode']) && $rmaData['return_mode'] == 'alfatrex') {
                        $vars['return_url'] = "https://www.alfatrex.id/homepage/dropstore/";
                    }
                          
                    //send email
                    $templateId = 'hypework_productreturn_template_return';
                    $transport = $this->_transportBuilder->setTemplateIdentifier($templateId)
                        ->setTemplateOptions(['area' => 'frontend', 'store' => $this->_storeManager->getStore()->getId()])
                        ->setTemplateVars($vars)
                        ->setFrom('general')
                        ->addTo($recipients)
                        ->getTransport();

                    $transport->sendMessage();
                    
                    if($transport){
                        $notify = true;
                        $visible = true;
                        $status = $order->getStatus();
                        
                        // adding status history comment
                        $history = $order->addStatusHistoryComment($returnedItemMessage, $status);
                        $history->setIsVisibleOnFront($visible);
                        $history->setIsCustomerNotified($notify);
                        $history->save();
                        
                        // sending order update mail to customer
                        //$this->sendEmail->send($order,$notify,$returnedItemMessage);
                        $pdf = $this->rmaPdf->getPdf($order, $pdfItems);
                        $this->sendCustomerEmail($pdf, $vars);
                    }
                    
                    $this->eventManager->dispatch('return_request_submit_after', ['order_id' => $orderId]);
                    return sprintf('%s', __("Return Request Sent Successfully"));

                } catch (\Exception $e) {
                        $debugMessage = $e->getMessage();
                        return sprintf('%s', __("Cannot submit return request, please try again"));
                }
        }
    }
    
    protected function sendCustomerEmail($pdf, $vars){
        $templateId = 'hypework_productreturn_template_return_customer';
        $order = $vars['order'];
        $fileName = 'rma_'.$order->getIncrementId().'.pdf';
        $transport = $this->_transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions(['area' => 'frontend', 'store' => $this->_storeManager->getStore()->getId()])
            ->setTemplateVars($vars)
            ->setFrom('general')
            ->addTo($order->getCustomerEmail())
            ->addAttachment(
                    $pdf->render(), 'application/pdf', \Zend_Mime::DISPOSITION_ATTACHMENT,\Zend_Mime::ENCODING_BASE64, $fileName
            )
            ->getTransport();

        $transport->sendMessage();
    }

}
