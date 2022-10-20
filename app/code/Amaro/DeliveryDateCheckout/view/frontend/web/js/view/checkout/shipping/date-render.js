define([
    'loader',
    'Amaro_DeliveryDateCheckout/js/action/saveDeliveryDate',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'mage/storage',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Customer/js/model/customer',
    'ko',
    'Magento_Customer/js/customer-data',
    'uiComponent',
    'jquery',
    'mage/translate',
    'mage/calendar',
    'domReady!'
], function (
    loader,
    saveDeliveryDate,
    quote,
    urlBuilder,
    storage,
    errorProcessor,
    customer,
    ko,
    customerData,
    Component,
    $,
    $t
) {
    'use strict';

    return Component.extend({
        isLoading: ko.observable(false),
        deliveryDate: ko.observable(),
        hasWarnings: ko.observable(),
        defaults: {
            template: 'Amaro_DeliveryDateCheckout/checkout/shipping/datepicker-field',
            isLoading: false,
            delivery_date: null,
            deliveryDate: '',
            hasWarnings: false,
            listens: {
                'delivery_date': 'deliveryChanged'
            }
        },

        /**
         * Observe the current property
         * @returns {*}
         */
        initObservable: function () {
            return this._super().observe(['delivery_date','deliveryDate', 'isLoading','hasWarnings']);
        },

        onElementRender: function (dateInput) {
            this.dateInput = dateInput;
            $(this.dateInput).calendar({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                currentText: $t('Go Today'),
                closeText: $t('Close'),
                format : 'Y.m.d',
                dateFormat: 'Y-m-d',
                timepicker : false,
                beforeShowDay: this.disableSundays,
                minDate: '+1'
            });

            let deliveryDate = window.checkoutConfig.deliveryDate;

            if (deliveryDate !== undefined) {
                this.deliveryDate(deliveryDate);
                this.warningMessages(deliveryDate);
            }
        },

        deliveryChanged: function (deliveryDate) {
            let deferred, self;

            deferred = $.Deferred();
            self = this;
            self.isLoading(true);
            saveDeliveryDate(deferred, deliveryDate);
            $.when(deferred).done(function () {
                self.warningMessages(deliveryDate);
            }).fail().always(function () {
                self.isLoading(false);
            });
        },

        disableSundays: function (date) {
            let config,day;

            config = window.checkoutConfig;
            day = date.getDay();

            if (day === 6) {
                return [true, config.deliveryData[day].cssClass[0], config.deliveryData[day].warnings[0]];
            }
            return [  day > 0 && day < 6, '' ];
        },

        warningMessages: function (deliveryDate) {
            let date, warnings;

            date = new Date(deliveryDate);
            warnings = window.checkoutConfig.deliveryData[date.getDay()].warnings;
            if (warnings.length > 0) {
                $('#date-input-field-alert').empty();
                this.hasWarnings(true);
                $.each(warnings, function (i, e) {
                    $('#date-input-field-alert').append('<p>' + e + '</p>');
                });
            } else {
                this.hasWarnings(false);
            }
        }
    });
});
