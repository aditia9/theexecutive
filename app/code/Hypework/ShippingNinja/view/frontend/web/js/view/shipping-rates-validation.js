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
        'Hypework_ShippingNinja/js/model/shipping-rates-validator',
        'Hypework_ShippingNinja/js/model/shipping-rates-validation-rules'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        ninjaShippingRatesValidator,
        ninjaShippingRatesValidationRules
    ) {
        'use strict';
        defaultShippingRatesValidator.registerValidator('ninja', ninjaShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('ninja', ninjaShippingRatesValidationRules);
        return Component;
    }
);
