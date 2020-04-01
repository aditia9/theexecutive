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
        'Hypework_ShippingSap/js/model/shipping-rates-validator',
        'Hypework_ShippingSap/js/model/shipping-rates-validation-rules'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        sapShippingRatesValidator,
        sapShippingRatesValidationRules
    ) {
        'use strict';
        defaultShippingRatesValidator.registerValidator('sap', sapShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('sap', sapShippingRatesValidationRules);
        return Component;
    }
);
