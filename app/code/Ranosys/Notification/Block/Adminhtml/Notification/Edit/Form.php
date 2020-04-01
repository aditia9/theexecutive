<?php

namespace Ranosys\Notification\Block\Adminhtml\Notification\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {

    protected $systemStore;
    protected $wysiwyg;
    protected $optionResolver;

    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\Framework\Data\FormFactory $formFactory,
            \Magento\Store\Model\System\Store $systemStore,
            \Magento\Cms\Model\Wysiwyg\Config $wysiwyg, 
            \Ranosys\Notification\Model\Option $optionResolver,
            array $data = []
    ) {

        $this->systemStore = $systemStore;
        $this->optionResolver = $optionResolver;
        $this->wysiwyg = $wysiwyg;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm() {

        $model = $this->_coreRegistry->registry('row_data');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(['data' => [
                'id' => 'edit_form',
                'enctype' => 'multipart/form-data',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]
        ]);

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Notification Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addType('image', '\Ranosys\Notification\Block\Adminhtml\Notification\Helper\Image');

        $fieldset->addField(
                'status', 'select', [
            'label' => __('Status'),
            'title' => __('Status'),
            'name' => 'status',
            'required' => true,
            'values' => $this->getStatusOptions(),
            'disabled' => $isElementDisabled,
            'note' => 'Status of notification',
                ]
        );

          $fieldset->addField(
                'notification_type', 'select', [
            'label' => __('Notification Type'),
            'title' => __('Notification Type'),
            'name' => 'notification_type',
            'required' => true,
            'values' => $this->getNotificationOptions(),
            'disabled' => $isElementDisabled,
            'note' => 'Type of notification',
                ]
        );
        
        $fieldset->addField(
                'title', 'text', [
            'name' => 'title',
            'label' => __('Title'),
            'title' => __('Title'),
            'required' => true,
            'disabled' => $isElementDisabled,
            'note' => 'Max 100 charactors.',
            'maxlength' => '100',
                ]
        );

    $typefield =  $fieldset->addField(
                'type', 'select', [
            'label' => __('Redirection Type'),
            'title' => __('Redirection Type'),
            'name' => 'type',
            'required' => true,
            'values' => $this->getTypeOptions(),
            'disabled' => $isElementDisabled,
            'note' => 'Redirection Type',
                ]
        );

        $fieldset->addField(
            'type_id', 'text', [
            'name' => 'type_id',
            'label' => __('Redirection Type Id'),
            'title' => __('Redirection Type Id'),
            'disabled' => $isElementDisabled,
            'note' => __('Insert Category Id {Ex. 1,2} For Category Promotion Type, SKU {Ex. fa344, qw231}  For Product, Leave blank in case of Notify List.'),
            'maxlength' => '100',
                ]
        );

        $fieldset->addField(
            'redirection_title', 'text', [
            'name' => 'redirection_title',
            'label' => __('Redirection Title'),
            'title' => __('Redirection Title'),
            'disabled' => $isElementDisabled,
            'note' => __('Can leave blank in case of Product and Category Redirection Type'),
            'maxlength' => '100',
                ]
        );
              
        
        $fieldset->addField(
            'description', 'editor', [
            'name' => 'description',
            'label' => __('Descripton'),
            'title' => __('Descripton'),
            'required' => true,
            'config' => $this->wysiwyg->getConfig(),
            'wysiwyg' => true,
            'disabled' => $isElementDisabled,
            'note' => __('Max 150 charactors.'),
            'maxlength' => '150',
                ]
        );

        $fieldset->addField(
            'store_id', 'multiselect', [
            'label' => __('Store'),
            'title' => __('Store'),
            'name' => 'store_id',
            'required' => true,
            'values' => $this->systemStore->getStoreValuesForForm(false, true),
            'disabled' => $isElementDisabled,
            'note' => __('Scope of notification.')
                ]
        );


        $fieldset->addField(
            'image', 'image', array(
            'name' => 'image',
            'label' => __('Image'),
            'title' => __('Image'),
            'note' => __('Allow image type: jpg, jpeg, gif, png'),
                )
        );


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getStatusOptions() {
        $options = $this->optionResolver->getOptionArray();
        return $options;
    }

    public function getTypeOptions() {
        $options = $this->optionResolver->getTypeArray();
        return $options;
    }

    public function getNotificationOptions() {
        $options = $this->optionResolver->getNotificationArray();
        return $options;
    }
}
