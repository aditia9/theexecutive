<?php
namespace Hypework\BanktransferConfirmation\Controller\Confirmation;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_storeManager;
    protected $_scopeConfig;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	)
	{
		$this->_pageFactory = $pageFactory;
		$this->_storeManager = $storeManager;
		$this->_scopeConfig = $scopeConfig;
		return parent::__construct($context);
	}

	public function execute()
	{
		$enable = $this->_scopeConfig->getValue('hypework_banktransferconfirmation/configuration/is_enabled');

		if (!$enable) {
			return;
		}
		
		$resultPage = $this->_pageFactory->create();
		$resultPage->getConfig()->getTitle()->set(__('Bank Transfer Confirmation Form'));
		return $resultPage;
	}

	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
