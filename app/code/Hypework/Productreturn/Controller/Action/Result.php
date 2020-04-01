<?php
namespace Hypework\Productreturn\Controller\Action;

class Result extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_storeManager;
    protected $_resultRedirect;
	protected $_customerSession;
	protected $_messageManager;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Customer\Model\Session $customerSession
	)
	{
		$this->_pageFactory = $pageFactory;
		$this->_storeManager = $storeManager;
		$this->_resultRedirect = $context->getResultFactory();
		$this->_customerSession = $customerSession;
		$this->_messageManager = $context->getMessageManager();
		return parent::__construct($context);
	}

	public function execute()
	{
		if(!$this->_customerSession->getProductReturnResultValid()) {

			$baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        	$resultRedirect = $this->_resultRedirect->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        	$resultRedirect->setUrl($baseUrl.'productreturn/action/index');
        	$this->_messageManager->addError(__('Please submit your Product Return Form.'));
        	return $resultRedirect;

		} else {
			$this->_customerSession->unsProductReturnResultValid();
			$resultPage = $this->_pageFactory->create();
			$resultPage->getConfig()->getTitle()->set(__('Request Form Return'));
			return $resultPage;
		}		
	}

}
