<?php

namespace Hypework\Shipping\Controller\Adminhtml\Region;

class Delete extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::region_delete';
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
		// check if we know what should be deleted
        $region_id = $this->getRequest()->getParam('region_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($region_id && (int) $region_id > 0) {
            $title = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Hypework\Shipping\Model\Region');
                $regionModel = $model->load($region_id);
                if ($regionModel->getRegionId()) {
                    $title = $model->getDefaultName();
                    $model->delete();
                    $this->messageManager->addSuccess(__('The "'.$title.'" Region has been deleted.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['region_id' => $region_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Region to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
	}
}