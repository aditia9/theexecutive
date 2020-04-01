<?php
namespace Hypework\Productreturn\Controller\Action;

class Submit extends \Magento\Framework\App\Action\Action
{
	protected $_request;
	protected $_resultRedirect;
	protected $_storeManager;
	protected $_messageManager;
	protected $_transportBuilder;
	protected $_scopeConfig;
	protected $_logger;
	protected $_customerSession;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\App\Request\Http $request,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Customer\Model\Session $customerSession
	) {
		$this->_request = $request;
		$this->_resultRedirect = $context->getResultFactory();
		$this->_storeManager = $storeManager;
		$this->_messageManager = $context->getMessageManager();
		$this->_transportBuilder = $transportBuilder;
		$this->_scopeConfig = $scopeConfig;
		$this->_logger = $logger;
		$this->_customerSession = $customerSession;

		return parent::__construct($context);
	}

    public function execute()
    {
    	$debugMessage = '';
        $post = $this->_request->getPost();

        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $resultRedirect = $this->_resultRedirect->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        if($this->_scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) != '1') {
        	$debugMessage = __('Module hypework_Productreturn is not enabled');
        	$resultRedirect->setUrl($baseUrl.'productreturn/action/index');
        	$this->_messageManager->addError(__('Submit Product Return form was failed. Please try again.'));
        } else {
	        
	        if($post) {
	        	try {
	        		$recipients = explode(';', $this->_scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/emailrecipients', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
	        		
	        		$vars = array(
	        				'store' => $this->_storeManager->getStore(),
		                    'order_id' => $post->get('orderid'),
		                    'name' => $post->get('name'),
		                    'email_submitter' => $post->get('email_submitter'),
		                    'phone' => $post->get('phone'),
		                    'sku' => $post->get('sku'),
		                    'reason' => $post->get('reason'),
		                    'message' => $post->get('message'),
	        			);

	        		//send email
	        		$templateId = 'hypework_productreturn_template_return';
	        		$transport = $this->_transportBuilder->setTemplateIdentifier($templateId)
			            ->setTemplateOptions(['area' => 'frontend', 'store' => $this->_storeManager->getStore()->getId()])
			            ->setTemplateVars($vars)
			            ->setFrom('general')
			            ->addTo($recipients)
			            ->getTransport();

			        $transport->sendMessage();

	        		$resultRedirect->setUrl($baseUrl.'productreturn/action/result');
	        		$debugMessage = __('Submit product return is success. ' . json_encode($post));
	        		$this->_customerSession->setProductReturnResultValid('1');

	        	} catch (Exception $e) {
	        		$debugMessage = $e->getMessage();
	        		$resultRedirect->setUrl($baseUrl.'productreturn/action/index');
	        		$this->_messageManager->addError(__('Submit Product Return form was failed. Please try again.'));
	        	}
	        } else {
	        	$debugMessage = __('Post params is not available');
	        	$resultRedirect->setUrl($baseUrl.'productreturn/action/index');
	        	$this->_messageManager->addError(__('Submit Product Return form was failed. Please try again.'));
	        }
	    }

	    if($this->_scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/debuglog', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == 1) {
	    	$this->_logger->debug($debugMessage);
	    }

	    return $resultRedirect;  
    }
}
