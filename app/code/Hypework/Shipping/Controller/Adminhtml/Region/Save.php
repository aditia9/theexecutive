<?php

namespace Hypework\Shipping\Controller\Adminhtml\Region;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Hypework\Shipping\Model\ResourceModel\Region;
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
            $id = $this->getRequest()->getParam('region_id');
            /** @var \Hypework\Shipping\Model\Region $model */
            $model = $this->_objectManager->create('Hypework\Shipping\Model\Region')->load($id);
            if (!$model->getRegionId() && $id) {
                $this->messageManager->addError(__('This Region no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            //Hardcoded ID for country_id
            $data['country_id'] = 'ID';

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Region.'));
                
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['region_id' => $model->getRegionId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Region: '.$e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            if ($this->getRequest()->getParam('region_id')) {
                return $resultRedirect->setPath('*/*/edit', ['region_id' => $this->getRequest()->getParam('region_id')]);
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
        if ($this->_authorization->isAllowed('Hypework_Shipping::region_create') || $this->_authorization->isAllowed('Hypework_Shipping::region_edit')) {
            return true;
        }
        return false;
    }
}