/**
 * Created by rifki on 3/22/18.
 */
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
                template: 'Hypework_Payment/payment/prismalink-vabca',
                setWindow: false,
            },
            redirectAfterPlaceOrder: false,
            afterPlaceOrder: function () {
                window.location = url.build('payment/prismalink/redirect');
            },
            getPaymentInstruction: function() {
                return window.checkoutConfig.payment.prismalink_vabca.instructions;
            }
        });
    }
);
