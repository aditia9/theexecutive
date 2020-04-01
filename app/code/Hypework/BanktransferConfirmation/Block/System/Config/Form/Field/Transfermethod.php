<?php
namespace Hypework\BanktransferConfirmation\Block\System\Config\Form\Field;

class Transfermethod extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
	protected $_addAfter = true;

    protected $_addButtonLabel;
	
	protected function _construct(
    ) {
        parent::_construct();
        $this->_addButtonLabel = __('Add');
    }

    protected function _prepareToRender() {
        $this->addColumn('methods', array('label' => __('Methods')));
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    public function renderCellTemplate($columnName) {
        return parent::renderCellTemplate($columnName);
    }
}