<?php
namespace Hypework\Shipping\Block\Adminhtml\System\Config\Upload\Template;

class City extends \Magento\Config\Block\System\Config\Form\Field
{
    const BUTTON_TEMPLATE = 'system/config/button/link.phtml';
    const BLOCK_ID = 'city_upload_template_link';

    protected $_scopeConfig;

    public function __construct(\Magento\Backend\Block\Template\Context $context) {
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
    }
 
    /**
     * Set template to itself
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate(static::BUTTON_TEMPLATE);
        }
        return $this;
    }
    /**
     * Render button
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        // Remove scope label
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getAjaxUrl()//getAjaxCheckUrl()
    {
        return $this->getUrl('hypeworkshipping/city/template'); //hit controller by ajax call on button click.
    }
     /**
     * Get the button and scripts contents
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }    

    public function getBlockId()
    {
        return self::BLOCK_ID;
    }

}