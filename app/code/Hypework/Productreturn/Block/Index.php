<?php
namespace Hypework\Productreturn\Block;

class Index extends \Magento\Framework\View\Element\Template
{
	protected $_scopeConfig;

	public function __construct(\Magento\Framework\View\Element\Template\Context $context)
	{
		parent::__construct($context);
		$this->_scopeConfig = $context->getScopeConfig();
	}

	public function getReasonList()
	{
		$reasons = array();
		$value = $this->_scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/reasons', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		
		// if($value) {
		// 	$reasonList = unserialize($value);
			
		// 	foreach($reasonList as $reason) {
		// 		$reasons[] = $reason['reason_item'];
		// 	}
		// }

		return $reasons;
	}
}