<?php

namespace Hypework\Shipping\Block\Adminhtml\Region\Edit\Tab;

class General extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Active or InActive
     *
     * @var \Hypework\Shipping\Model\Config\Source\IsActive
     */
    protected $_status;
    /**
     * Yes or No
     *
     * @var \Hypework\Shipping\Model\Config\Source\Yesno
     */
    protected $_yesNo;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    /**
     * @param \Hypework\Shipping\Model\Config\Source\Yesno $yesNo
     * @param \Hypework\Shipping\Model\Config\Source\IsActive $status
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setActive(true);
    }
    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('General Information');
    }
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }
    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);
        $this->_addElementTypes($fieldset);

        $fieldset->addField(
            'code',
            'text',
            [
                'name' => 'code',
                'label' => __('Region Code'),
                'title' => __('Region Code'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'default_name',
            'text',
            [
                'name' => 'default_name',
                'label' => __('Region Name'),
                'title' => __('Region Name'),
                'required' => true
            ]
        );
        
        $formData = $this->_coreRegistry->registry('hypeworkshipping_region');
        if ($formData) {
            if ($formData->getRegionId()) {
                $fieldset->addField(
                    'region_id',
                    'hidden',
                    ['name' => 'region_id']
                );
            }
            $form->setValues($formData->getData());
        }
        $this->setForm($form);
        return parent::_prepareForm();
    }
}