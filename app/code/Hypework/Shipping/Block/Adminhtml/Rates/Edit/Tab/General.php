<?php

namespace Hypework\Shipping\Block\Adminhtml\Rates\Edit\Tab;

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

    protected $_carrierList;

    protected $_cityList;

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
        \Hypework\Shipping\Model\Config\Source\Adminhtml\CityList $cityList,
        \Hypework\Shipping\Model\Config\Source\Adminhtml\CarrierList $carrierList,
        array $data = []
    ) {
        $this->_regionList = $regionList;
        $this->_cityList = $cityList;
        $this->_carrierList = $carrierList;
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
        return __('General Information');
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
        $formData = $this->_coreRegistry->registry('hypeworkshipping_rates');

        /** @var \Magento\Framework\Data\Form $form */        
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);
        $this->_addElementTypes($fieldset);        

        $regionField = $fieldset->addField(
            'region',
            'select',
            [
                'name' => 'region',
                'label' => __('Region Name'),
                'title' => __('Region Name'),
                'required' => true,
                'values' => $this->_regionList->toOptionArray(),                
            ]
        );
        $cityField = $fieldset->addField(
            'city',
            'select',
            [
                'name' => 'city',
                'label' => __('City Name'),
                'title' => __('City Name'),
                'required' => true,
                'values' => ($formData->getRegionId() && $formData->getRegionId() != -1) ? $this->_cityList->toOptionArray($formData->getRegionId()) : null,
            ]
        );
        $carrierField = $fieldset->addField(
            'carrier',
            'select',
            [
                'name' => 'carrier',
                'label' => __('Carrier Name'),
                'title' => __('Carrier Name'),
                'required' => true,
                'values' => $this->_carrierList->toOptionArray(),                
            ]
        );
        $fieldset->addField(
            'rate',
            'text',
            [
                'name' => 'rate',
                'label' => __('Rate'),
                'title' => __('Rate'),
                'required' => true,
            ]
        );
        
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

                $formDataArr['city'] = $formDataArr['city_id'];
                unset($formDataArr['city_id']);

                $formDataArr['carrier'] = $formDataArr['carrier_id'];
                unset($formDataArr['carrier_id']);

                $form->setValues($formDataArr);
            }            
        }

        $regionField->setAfterElementHtml("
            <script type=\"text/javascript\">
                    require([
                    'jquery',
                    'mage/template',
                    'jquery/ui',
                    'mage/translate'
                ],
                function($, mageTemplate) {
                   $('#edit_form').on('change', '#region', function(event) {
                        $.ajax({
                                url         : '". $this->getUrl('hypeworkshipping/city/ajaxlist') . "region_id/' +  $('#region').val(),
                                type        : 'get',
                                dataType    : 'json',
                                showLoader  : true,
                                success     : function(data){
                                    $('#city').empty();
                                    $('#city').append(data.htmlcontent);
                                }
                            });
                   })
                }

            );
            </script>
        ");
                        
        $this->setForm($form);
        return parent::_prepareForm();
    }
}