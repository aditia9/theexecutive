<?php

namespace Hypework\Shipping\Block\Adminhtml\City\Edit\Tab;

class General extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    protected $_regionList;

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
        \Hypework\Shipping\Model\Config\Source\Adminhtml\RegionList $regionList,
        array $data = []
    ) {
        $this->_regionList = $regionList;        
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
        return __('General');
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
            'region',
            'select',
            [
                'name' => 'region',
                'label' => __('Region Name'),
                'title' => __('Region Name'),
                'required' => true,
                // 'value' => ($formData) ? $formData->getRegionId() : '',
                'values' => $this->_regionList->toOptionArray(),                
            ]
        );
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('City Name'),
                'title' => __('City Name'),
                'required' => true,
            ]
        );

        $formData = $this->_coreRegistry->registry('hypeworkshipping_city');
        if ($formData) {
            if ($formData->getEntityId()) {
                $fieldset->addField(
                    'entity_id',
                    'hidden',
                    ['name' => 'entity_id']
                );

                $formDataArr = $formData->getData();
                $formDataArr['region'] = $formDataArr['region_id'];
                unset($formDataArr['region_id']);
                $form->setValues($formDataArr);
            }            
        }
                        
        $this->setForm($form);
        return parent::_prepareForm();
    }
}