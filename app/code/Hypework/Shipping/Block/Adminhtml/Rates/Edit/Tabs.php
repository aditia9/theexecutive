<?php

namespace Hypework\Shipping\Block\Adminhtml\Rates\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('rates_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Rates Information'));
    }
    protected function _beforeToHtml()
    {
        $this->setActiveTab('general_section');
        return parent::_beforeToHtml();
    }
    /**
     * Prepare Layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->addTab(
            'general_section',
            [
                'label' => __('General Information'),
                'content' => $this->getLayout()->createBlock('Hypework\Shipping\Block\Adminhtml\Rates\Edit\Tab\General')->toHtml()
            ]
        );
                
        return parent::_prepareLayout();
    }
}