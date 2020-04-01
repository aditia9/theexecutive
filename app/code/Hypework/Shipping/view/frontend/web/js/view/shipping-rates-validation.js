/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-rates-validation-rules',
        'Hypework_Shipping/js/model/shipping-rates-validator',
        'Hypework_Shipping/js/model/shipping-rates-validation-rules'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        hypeworkShippingRatesValidator,
        hypeworkShippingRatesValidationRules
    ) {
        'use strict';
        defaultShippingRatesValidator.registerValidator('hypework', hypeworkShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('hypework', hypeworkShippingRatesValidationRules);
        return Component;
    }
);
