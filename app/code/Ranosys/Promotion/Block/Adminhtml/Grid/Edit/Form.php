<?php

namespace Ranosys\Promotion\Block\Adminhtml\Grid\Edit;

/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context,
     * @param \Magento\Framework\Registry $registry,
     * @param \Magento\Framework\Data\FormFactory $formFactory,
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
     * @param \Ranosys\Promotion\Model\Status $options,
     */
    public function __construct(
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Ranosys\Promotion\Model\Status $options,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );

       
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Promotion Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('promotion_id', 'hidden', ['name' => 'promotion_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Promotion'), 'class' => 'fieldset-wide']
            );
        }
        $fieldset->addType('image', '\Ranosys\Promotion\Block\Adminhtml\Grid\Helper\Image');
        $fieldset->addField(
            'promotion_title',
            'text',
            [
                'name' => 'promotion_title',
                'label' => __('Promotion Title'),
                'id' => 'title',
                'title' => __('Title'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        

        $fieldset->addField(
            'promotion_description',
            'textarea',
            [
                'name' => 'promotion_description',
                'label' => __('Promotion Description'),
                'style' => 'height:16em;',
                'required' => true,
             
            ]
        );
        
         $fieldset->addField(
            'promotion_type',
            'select',
            [
                'name' => 'promotion_type',
                'label' => __('Promotion Type'),
                'values' => $this->_options->getTypeArray(),
                'required' => true,
                
            ]
        );
         $fieldset->addField(
                'promotion_store',
                'multiselect',
                [
                    'name' => 'promotion_store[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true)
                ]
            );
          $fieldset->addField(
            'promotion_value',
            'text',
            [
                'name' => 'promotion_value',
                'label' => __('Promotion Value'),
                'required' => true,
                'note' => __('Insert Category Id {Ex. 1,2} For Category Promotion Type, SKU {Ex. fa344, qw231}  For Product, CMS Page Id {Ex. 1,2} For CMS '),
            ]
        );
           $fieldset->addField(
            'promotion_position',
            'text',
            [
                'name' => 'promotion_position',
                'label' => __('Promotion Position'),
                'required' => true,
             
            ]
        );

        $fieldset->addField(
            'promotion_image',
            'image',
            [
                'name' => 'promotion_image',
                'label' => __('Promotion Image'),
                'class' => 'required-entry',
                'style' => 'width:200px',
            ]
        );
        
        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
