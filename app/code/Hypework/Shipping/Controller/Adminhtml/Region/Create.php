<?php

namespace Hypework\Shipping\Controller\Adminhtml\Region;

class Create extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::region_create';
	protected $resultPageFactory = false;
    protected $resultForwardFactory;

	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

	public function execute()
	{
		$resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
	}
}