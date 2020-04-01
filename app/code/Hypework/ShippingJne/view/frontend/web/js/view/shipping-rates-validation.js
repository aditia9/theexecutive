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
        'Hypework_ShippingJne/js/model/shipping-rates-validator',
        'Hypework_ShippingJne/js/model/shipping-rates-validation-rules'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        jneShippingRatesValidator,
        jneShippingRatesValidationRules
    ) {
        'use strict';
        defaultShippingRatesValidator.registerValidator('jne', jneShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('jne', jneShippingRatesValidationRules);
        return Component;
    }
);
