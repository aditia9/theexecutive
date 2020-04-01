define(
    [
        'Magento_Checkout/js/view/payment/default',
        'jquery',
        'mage/url',
        'Magento_Ui/js/modal/alert',
        'Magento_Checkout/js/checkout-data',
        'mage/loader'
    ],
    function (Component, $, url, alert, checkout, loader) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Hypework_Payment/payment/ipay88-request-cc',
                setWindow: false
            },
            redirectAfterPlaceOrder: false,

            afterPlaceOrder: function () {
                window.location = url.build('payment/ipay88/requestcc');
            },
            getPaymentInstruction: function() {
                return window.checkoutConfig.payment.ipay88_cc.instructions;
            }
        });
    }
);
