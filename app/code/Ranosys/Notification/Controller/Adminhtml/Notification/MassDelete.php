<?php

namespace Ranosys\Notification\Controller\Adminhtml\Notification;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ranosys\Notification\Model\ResourceModel\Notification\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action {

    protected $filter;
    protected $collectionFactory;
    protected $notificationFactory;

    public function __construct(
    Context $context, Filter $filter,
            CollectionFactory $collectionFactory,
            \Ranosys\Notification\Model\Notification $notificationFactory
    ) {

        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->notificationFactory = $notificationFactory;
        parent::__construct($context);
    }

    public function execute() {



        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $recordDeleted = 0;
        $recordNotDeleted = 0;
        foreach ($collection->getItems() as $record) {
            $id = $record->getId();
            $rowData = $this->notificationFactory->load($id);
            if($rowData->getPublishStatus() == \Ranosys\Notification\Model\Notification::NOTIFICATION_STATUS_PENDING)
            {
                $rowData->delete();
                $recordDeleted++;
            }
            else
            {
                $recordNotDeleted++;
            }
        }
        
        if($recordNotDeleted)
        {
        $this->messageManager->addError(__('A total of %1 record(s) have not been deleted, as they might be published or sent', $recordNotDeleted));
        } 
        
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $recordDeleted));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Ranosys_Notification::row_data_delete');
    }

}
