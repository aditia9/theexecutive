<?php

namespace Hypework\Shipping\Controller\Adminhtml\Region;

class Edit extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::region_edit';
    protected $_coreRegistry;
	protected $resultPageFactory = false;

	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hypework_Shipping::shipping');
        return $resultPage;
    }

	public function execute()
	{
		// Get ID and create model
        $id = $this->getRequest()->getParam('region_id');
        $model = $this->_objectManager->create('Hypework\Shipping\Model\Region');
        $model->setData([]);
        // Initial checking
        if ($id && (int) $id > 0) {
            $model->load($id);
            if (!$model->getRegionId()) {
                $this->messageManager->addError(__('This Region no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $title = $model->getTitle();
        }
        $FormData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($FormData)) {
            $model->setData($FormData);
        }
        $this->_coreRegistry->register('hypeworkshipping_region', $model);
        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Region') : __('New Region'),
            $id ? __('Edit Region') : __('New Region')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Region'));
        $resultPage->getConfig()->getTitle()
            ->prepend($id ? 'Edit: '.$title.' ('.$id.')' : __('New Region'));
        return $resultPage;
	}
}