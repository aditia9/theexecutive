<?php

namespace Hypework\Shipping\Block\Adminhtml\City;
use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
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
     * Department edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'hypeworkshipping_city_id';
        $this->_blockGroup = 'Hypework_Shipping';
        $this->_controller = 'adminhtml_city';
        parent::_construct();
    }
    /**
     * Prepare layout.
     * Adding save_and_continue button
     *
     * @return $this
     */
    protected function _preparelayout()
    {
        if ($this->_isAllowedAction('Hypework_Shipping::city_create') || $this->_isAllowedAction('Hypework_Shipping::city_edit')) {
            $this->buttonList->update('save', 'label', __('Save City'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => [
                                'event' => 'saveAndContinueEdit',
                                'target' => '#edit_form'
                            ],
                        ],
                    ]
                ],
                -100
            );
            $city = $this->_coreRegistry->registry('hypeworkshipping_city');
            if (!empty($city)) {
                if ($city->getCityId() && $this->_isAllowedAction('Hypework_Shipping::city_delete')) {
                    $this->buttonList->add(
                        'delete',
                        [
                            'label'   => __('Delete'),
                            'class'   => 'delete',
                            'onclick' => 'deleteConfirm("Are you sure you want to delete this City?", "'.$this->getDeleteUrl().'")'
                        ],
                        -100
                    );
                }
            }
        } else {
            $this->removeButton('save');
        }
        return parent::_prepareLayout();
    }
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    /**
     * Retrieve delete Url.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl(
            '*/*/delete',
            [
                '_current' => true,
                'id' => $this->getRequest()->getParam('entity_id')
            ]
        );
    }
    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'active_tab' => ''
            ]
        );
    }
}