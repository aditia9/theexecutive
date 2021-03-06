<?php

namespace Hypework\Shipping\Controller\Adminhtml\Rates;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Hypework\Shipping\Model\ResourceModel\Rates;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {            
            $id = $this->getRequest()->getParam('entity_id');
            /** @var \Hypework\Shipping\Model\Rates $model */
            $model = $this->_objectManager->create('Hypework\Shipping\Model\Rates')->load($id);
            if (!$model->getEntityId() && $id) {
                $this->messageManager->addError(__('This Rates no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object objectManager
            $magentoDateObject = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
            $now = $magentoDateObject->gmtDate();

            $data['region_id'] = $data['region'];
            $data['city_id'] = $data['city'];
            $data['carrier_id'] = $data['carrier'];
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
            unset($data['region']);
            unset($data['city']);
            unset($data['carrier']);

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Rates.'));
                
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getEntityId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Rates: '.$e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            if ($this->getRequest()->getParam('entity_id')) {
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
            }
            return $resultRedirect->setPath('*/*/create');
        }
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed('Hypework_Shipping::rates_create') || $this->_authorization->isAllowed('Hypework_Shipping::rates_edit')) {
            return true;
        }
        return false;
    }
}