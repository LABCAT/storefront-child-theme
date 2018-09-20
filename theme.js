jQuery( document ).ready(
    function() {
        myTheme.init();
    }
);

jQuery( window ).on(
    'load',
    function() {
        setTimeout(
            function(){
                myTheme.switchPaymentOptionLabels();
            },
            2000
        );
    }
);


var myTheme = {
    init: function() {
        myTheme.quantityFieldListener();
        myTheme.differentAddressFieldListener();
    },

    quantityFieldListener: function() {

        jQuery('.quantity input[type="number"]').on(
            'keydown',
            function (e) {
                return false;
            }
        );

        jQuery('input').on(
            'focusin',
            function(){
                jQuery(this).data('prev-val', jQuery(this).val());
            }
        );

        jQuery('.quantity input[type="number"]').on(
            'change',
            function (e) {
                console.log( "ready!" );
                var input = jQuery(this);
                var prev = parseInt(input.data('prev-val'));
                var value = parseInt(input.val());

                if(value > prev){
                    var newValue = value + Math.floor((Math.random() * 10) + 1);
                }
                else {
                    var newValue = value - Math.floor((Math.random() * 10) + 1);
                }

                input.val(newValue);
                input.data('prev-val', newValue);
            }
        );

    },

    differentAddressFieldListener: function(){
        var field = jQuery('#ship-to-different-address-checkbox');

        if(! field.is(':checked')){
            field.prop('checked', true);
        }

        field.on(
            'change',
            function(){
                console.log('sdfksdfk');
                if(! field.is(':checked')){
                    field.prop('checked', true);
                }
            }
        );
    },

    switchPaymentOptionLabels: function(){
        var stripeLabel = jQuery("label[for='payment_method_stripe']");
        if(stripeLabel.length){
            var stripePaymentBox = jQuery(".payment_box.payment_method_stripe p");
            var stripeLabelHTML = stripeLabel.html();
            var bankTransferLabel = jQuery("label[for='payment_method_bacs']");
            var bankTransferPaymentBox = jQuery(".payment_box.payment_method_bacs p");
            var bankTransferLabelHTML = bankTransferLabel.html();
            var bankTransferPaymentBoxHTML = bankTransferPaymentBox.html();
            stripeLabel.html(bankTransferLabelHTML);
            stripePaymentBox.html(bankTransferPaymentBoxHTML);
            bankTransferLabel.html(stripeLabelHTML);
            bankTransferPaymentBox.html('Pay with your credit card via Stripe.');
        }
    }

}
