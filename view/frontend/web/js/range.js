define([
    "ko",
    "uiComponent",
    "jquery",
    "jquery/ui"
], function (ko, Component, $) {
    'use strict'

    return Component.extend({
        defaults: {
            template: 'Tesche_RangeProducts/product-list'
        },
        /**
         * An observable array containing the list of products to be displayed.
         * 
         * @type {Array.<Object>}
         */
        products: ko.observableArray([]),

        message: ko.observableArray([]),

        /**
         * Initializes the component.
         */
        initialize: function () {
            this._super()
        },

        /**
         * Sends an AJAX request to retrieve a list of products within a given range.
         * 
         * @function
         */
        getProducts: function () {
            let self = this
            let form = $('.form.form-range-price').serializeArray()


            if (this.validate()) {
                $.ajax({
                    url: window.BASE_URL + 'rangeproducts/form/range',
                    data: form,
                    async: false
                }).done((response) => {
                    if (response.error == undefined) {
                        self.products.removeAll()
                        response.forEach(product => {
                            self.products.push(product)
                        })
                    } else {
                        self.message.push(response)
                    }
                })
            }

        },

        /**
         * Validates the input values provided by the user.
         * 
         * @function
         * 
         * @returns {boolean}
         */
        validate: function () {
            let self = this
            let form = $('.form.form-range-price').serializeArray()
            let result = true
            let low, high

            self.message.removeAll()
            form.forEach(input => {
                if (!input.value) {
                    self.products.removeAll()
                    self.message.push({ 'error': "Please fill out " + input.name + " field" })
                    result = false
                } else if (input.name == 'low-range') {
                    low = parseInt(input.value)
                } else if (input.name == 'high-range') {
                    high = parseInt(input.value)
                }
            })

            if (result) {
                if (low * 5 < high) {
                    result = false
                    self.message.push({ 'error': "The search can be performed with a maximum of 5x the minimum value selected" })
                } else if (low > high) {
                    console.log(low + ' > ' + high)
                    result = false
                    self.message.push({ 'error': "The high range field must be higher than the low range field" })
                }
            }

            return result
        },
    })
})