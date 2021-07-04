define(
    [
        'ko',
        'uiComponent',
        'mage/url',
        'mage/storage',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Customer/js/model/customer'
    ],
    function (
        ko,
        Component,
        urlBuilder, 
        storage,
        _,
        stepNavigator,
        customer
    ) {
        'use strict';
        /**
        * check-login - is the name of the component's .html template
        */
        return Component.extend({
            defaults: {
                template: 'AHT_CustomCheckout/delivery-step'
            },

            //add here your logic to display step,
            isVisible: ko.observable(true),
            isLogedIn: customer.isLoggedIn(),
            //step code will be used as step content id in the component template
            stepCode: 'isLogedCheck',
            //step title value
            stepTitle: 'Step New',
            deliveyDate: ko.observable(),
            deliveryComment: ko.observable(),
            /**
            *
            * @returns {*}
            */
            initialize: function () {
                this._super();
                // register your step
                stepNavigator.registerStep(
                    this.stepCode,
                    //step alias
                    null,
                    this.stepTitle,
                    //observable property with logic when display step or hide step
                    this.isVisible,

                    _.bind(this.navigate, this),

                    /**
                    * sort order value
                    * 'sort order value' < 10: step displays before shipping step;
                    * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                    * 'sort order value' > 20 : step displays after payment step
                    */
                    15
                );

                return this;
            },

            /**
            * The navigate() method is responsible for navigation between checkout step
            * during checkout. You can add custom logic, for example some conditions
            * for switching to your custom step
            */
            navigate: function () {

            },

            /**
            * @returns void
            */
            navigateToNextStep: function () {
                    var self = this;
                    var date = self.deliveyDate();
                    var comment = self.deliveryComment();
                    var serviceUrl = urlBuilder.build('delivery/delivery/checkout');
                    stepNavigator.next();

                    return storage.post(
                        serviceUrl,
                        JSON.stringify({'date': date, 'comment': comment}),
                        false
                    ).done(function (response) {
                        console.log(response);
                    }
                    ).fail(function (response) {
                        // code khi fail
                        // console.log("không nhận được data");
                    });
            }
        });
    }
);
