<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WoocommerceExtensions {


    public function __construct() {
        //add filters
        add_filter( 'woocommerce_checkout_fields' , array( $this, 'modify_checkout_fields' ) );
        add_filter( 'woocommerce_billing_fields' , array( $this, 'modify_billing_fields' ) );
        add_filter( 'woocommerce_shipping_fields' , array( $this, 'modify_shipping_fields' ) );
    }

    public function modify_checkout_fields( $fields ){
        unset($fields['order']['order_comments']);
        unset($fields['billing']['billing_state']);
        unset($fields['shipping']['shipping_state']);
        return $fields;
    }

    public function modify_billing_fields( $fields ) {
    	return $this->randomize_fields( $fields );
    }

    public function modify_shipping_fields( $fields ) {
    	return $this->randomize_fields( $fields );
    }

    public function randomize_fields( $fields ) {
        $index = 0;
        $priorities = [ 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110 ];
        shuffle( $priorities );

        foreach( $fields as $key => $field) {
            $fields[$key]['priority'] = $priorities[ $index ];
            $fields[$key]['class'][] = 'margin-bottom-' .  $priorities[ array_rand( $priorities ) ];
            $fields[$key]['input_class'][] = 'width-' .  $priorities[ array_rand( $priorities ) ];
            $fields[$key]['input_class'][] = 'background-color-' .  $priorities[ array_rand( $priorities ) ];
            $index++;
        }

    	return $fields;
    }



}

new WoocommerceExtensions();
