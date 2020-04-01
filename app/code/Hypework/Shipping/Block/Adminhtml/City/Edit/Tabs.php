<?php

namespace Hypework\Shipping\Block\Adminhtml\City\Edit;

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
        $this->setId('city_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('City Information'));
    }
    protected function _beforeToHtml()
    {
        $this->setActiveTab('general_section');
        return parent::_beforeToHtml();
    }
   
}