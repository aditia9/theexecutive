<?php

namespace Hypework\Shipping\Block\Adminhtml\Region\Edit;

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
        $this->setId('region_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Region Information'));
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
                'content' => $this->getLayout()->createBlock('Hypework\Shipping\Block\Adminhtml\Region\Edit\Tab\General')->toHtml()
            ]
        );
                
        return parent::_prepareLayout();
    }
}