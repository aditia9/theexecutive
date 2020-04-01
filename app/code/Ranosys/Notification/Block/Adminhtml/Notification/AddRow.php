<?php

namespace Ranosys\Notification\Block\Adminhtml\Notification;

class AddRow extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Imagegallery Images Edit Block.
     */
    protected function _construct()
    {
        
        $notification = $this->_coreRegistry->registry('row_data');
        $id = $notification->getId();
        $this->_objectId = 'row_id';
        $this->_blockGroup = 'Ranosys_Notification';
        $this->_controller = 'adminhtml_notification';
        parent::_construct();
        if ($this->_isAllowedAction('Ranosys_Notification::add_row')) {
            $this->buttonList->update('save', 'label', __('Save'));
        } else {
            $this->buttonList->remove('save');
        }

        $this->buttonList->remove('reset');
    
        if($notification->canPublish()) {
            $this->addButton(
                'publish',
                [
                    'label' => __('Publish'),
                    'onclick' => 'setLocation(\' ' .  $this->getUrl('*/*/publish', array('id' => $id)) . '\')',
                    'class' => 'publish',
                    'level' => -1
                ]
            );
        }
    }
    

    public function getHeaderText()
    {
        return __('Add Notification Data');
    }


    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }

        return $this->getUrl('*/*/save');
    }
  
}
