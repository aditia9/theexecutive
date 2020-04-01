<?php

namespace Hypework\Shipping\Controller\Adminhtml\Rates;

class Delete extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::rates_delete';
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
        $entity_id = $this->getRequest()->getParam('entity_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($entity_id && (int) $entity_id > 0) {
            $title = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Hypework\Shipping\Model\Rates');
                $ratesModel = $model->load($entity_id);
                if ($ratesModel->getEntityId()) {
                    $title = $model->getDefaultName();
                    $model->delete();
                    $this->messageManager->addSuccess(__('The "'.$title.'" Rates has been deleted.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $entity_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Rates to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
	}
}