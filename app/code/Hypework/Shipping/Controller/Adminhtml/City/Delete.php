<?php

namespace Hypework\Shipping\Controller\Adminhtml\City;

class Delete extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::city_delete';
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
        $city_id = $this->getRequest()->getParam('entity_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($city_id && (int) $city_id > 0) {
            $title = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Hypework\Shipping\Model\City');
                $cityModel = $model->load($city_id);
                if ($cityModel->getEntityId()) {
                    $title = $model->getName();
                    $model->delete();
                    $this->messageManager->addSuccess(__('The "'.$title.'" City has been deleted.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $city_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('City to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
	}
}