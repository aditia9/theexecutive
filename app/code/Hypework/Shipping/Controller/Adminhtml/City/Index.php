<?php

namespace Hypework\Shipping\Controller\Adminhtml\City;

class Index extends \Magento\Backend\App\Action 
{
	protected $resultPageFactory = false;

	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

	public function execute()
	{
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(
            'Hypework Shipping',
            'Manage City'
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Hypework Shipping'));
        $resultPage->getConfig()->getTitle()
            ->prepend('Manage City');
            
        return $resultPage;
	}
}