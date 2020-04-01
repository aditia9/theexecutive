<?php

namespace Hypework\Productreturn\Block\System\Config\Form\Field;

class Reason extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
	protected $_columns = [];
    protected $_reasonListRenderer;

    protected $_addAfter = true;

    protected $_addButtonLabel;

    protected function _construct(
    ) {
        parent::_construct();        
        $this->_addButtonLabel = __('Add');
    }

     protected function _prepareToRender() {        
        $this->addColumn('reason_item', array('label' => __('Reason Item')));
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

}