<?php
namespace Hypework\Shipping\Ui;

class Sorting
{
	/**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        
    	if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']
        )) {
            $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
            foreach ($configuration as $paymentGroup => $groupConfig) {
                if (isset($groupConfig['component']) && $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {
                	$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['country_id']['sortOrder'] = 100;
                	$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['region_id']['sortOrder'] = 101;
                	$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['city'] = 
                    [
                        'component' => 'Magento_Ui/js/form/element/select',
                        'config' => [
                            'customScope' => 'billingAddress',
                            'template' => 'ui/form/field',
                            'elementTmpl' => 'ui/form/element/select',
                            'name' => __('City'),

                        ],
                        'dataScope' => 'billingAddress'.$paymentGroup.'.city',
                        'label' => __('City'),
                        'provider' => 'checkoutProvider',
                        'visible' => true,
                        'sortOrder' => 102,
                        'validation' => [
                            'required-entry' => true,
                        ]
                    ];
    			}
    		}
        }

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
            ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']
        )) {
            $data = [
                100 => 'country_id',
                101 => 'region',
                101 => 'region_id'
            ];
            foreach ($data as $key => $value) {
                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']
                ['children'][$value]['sortOrder'] = $key;
            }
        	
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['city'] = 
            [
                'component' => 'Magento_Ui/js/form/element/select',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/select',
                    'name' => __('City'),
                ],
                'dataScope' => 'shippingAddress.city',
                'label' => __('City'),
                'provider' => 'checkoutProvider',
                'visible' => true,
                'sortOrder' => 102,
                'validation' => [
                    'required-entry' => false,
                ]
            ];
        }


        return $jsLayout;
    }
}