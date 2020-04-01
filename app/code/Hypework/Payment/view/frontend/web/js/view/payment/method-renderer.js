define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list',
        'jquery'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'ipay88_cc',
                component: 'Hypework_Payment/js/view/payment/method-renderer/ipay88-cc'
            },
            {
                type: 'prismalink_vabca',
                component: 'Hypework_Payment/js/view/payment/method-renderer/prismalink-vabca'
            }
        );
        return Component.extend({});
    }
);