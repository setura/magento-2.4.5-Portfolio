define(['jquery'], function ($) {
    'use strict';

    return function () {
        $.validator.addMethod(
            'validate-phone-number',

            function (value) {
                return /\+353\d{9}$/gm.test(value);
            },
            $.mage.__('This number should start with +353 and have a total of 12 digits')
        );
    };
});
