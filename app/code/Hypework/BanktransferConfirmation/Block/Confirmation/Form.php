<?php
namespace Hypework\BanktransferConfirmation\Block\Confirmation;

class Form extends \Magento\Framework\View\Element\Template
{
	protected $_scopeConfig;

	protected $_serialize;

	protected $_session;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Serialize\Serializer\Json $serialize,
		\Magento\Customer\Model\SessionFactory $session
	)
	{
		parent::__construct($context);
		$this->_scopeConfig = $context->getScopeConfig();
		$this->_serialize = $serialize;
		$this->_session = $session;
	}

	public function getBanksRecipient()
	{
		$banks = array();
		$value = $this->_scopeConfig->getValue('hypework_banktransferconfirmation/configuration/bank_recipient', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

		if($value) {
			$bankList = $this->_serialize->unserialize($value);
			
			foreach($bankList as $bank) {
				$banks[] = $bank['banks'];
			}
		}

		return $banks;
	}

	public function getTransferMethod()
	{
		$methods = array();
		$value = $this->_scopeConfig->getValue('hypework_banktransferconfirmation/configuration/transfer_method', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

		if($value) {
			$bankList = $this->_serialize->unserialize($value);
			
			foreach($bankList as $method) {
				$methods[] = $method['methods'];
			}
		}

		return $methods;
	}

	public function getCustomerEmail()
	{
		$customerSession = $this->_session->create();

		return $customerSession->getCustomer()->getEmail();
	}
}