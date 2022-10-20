define([
    'loader',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'mage/storage',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/shipping-rate-registry'
], function (
    loader,
    quote,
    urlBuilder,
    storage,
    errorProcessor,
    customer,
    rateReg
) {
    'use strict';

    return function (deferred, deliveryDate) {
        let serviceUrl, payload, address;

        deferred = deferred || $.Deferred();
        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/amaro-deliverydatecheckout/mine/delivery/:cartId', {
                cartId: quote.getItems()[0].quote_id
            });

        } else {
            serviceUrl = urlBuilder.createUrl('/amaro-deliverydatecheckout/guest/delivery/:cartId', {
                cartId: quote.getItems()[0].quote_id
            });
        }

        payload = {
            deliveryDate
        };

        storage.post(
            serviceUrl, JSON.stringify(payload)
        ).done(function (response) {
            deferred.resolve(response);
        }).fail(function (response) {
            errorProcessor.process(response);
            deferred.reject(response);
        }).always(
            function () {
                address = quote.shippingAddress();
                rateReg.set(address.getKey(), null);
                rateReg.set(address.getCacheKey(), null);
                quote.shippingAddress(address);
            }
        );
    };
});
