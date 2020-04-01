<?php
namespace Hypework\Productreturn\Controller\Action;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_storeManager;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager)
	{
		$this->_pageFactory = $pageFactory;
		$this->_storeManager = $storeManager;
		return parent::__construct($context);
	}

	public function execute()
	{
		$resultPage = $this->_pageFactory->create();
		$resultPage->getConfig()->getTitle()->set(__('Request Form Return'));
		return $resultPage;
	}

	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
