<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WoocommerceExtensions {


    public function __construct() {
        add_action( 'woocommerce_after_order_notes', array( $this, 'custom_checkout_fields' ) );
        add_action( 'woocommerce_checkout_process',array( $this, 'custom_checkout_fields_validation' ) );
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

    public $priorities = [ 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110 ];

    public function randomize_fields( $fields ) {
        $index = 0;
        shuffle( $this->priorities );

        foreach( $fields as $key => $field) {
            $fields[$key]['required'] = true;
            $fields[$key]['priority'] = $this->priorities[ $index ];
            $fields[$key]['class'][] = 'margin-bottom-' .  $this->priorities[ array_rand( $this->priorities ) ];
            $fields[$key]['input_class'][] = 'width-' .  $this->priorities[ array_rand( $this->priorities ) ];
            $fields[$key]['input_class'][] = 'background-color-' .  $this->priorities[ array_rand( $this->priorities ) ];
            $index++;
        }

    	return $fields;
    }

    /*
    https://plentifun.com/funny-trivia-questions-answers
    */
    public $security_questions = [
        'question_1' => [
            'q' => 'What is a group of unicorns known as?',
            'a' => 'A blessing'
        ],
        'question_2' => [
            'q' => 'What is the fear of being buried alive known as?',
            'a' => 'Taphophobia'
        ],
        'question_3' => [
            'q' => 'Which planets in the Solar System are known as the Gas Giants?',
            'a' => 'Jupiter, Saturn, Uranus, and Neptune'
        ],
        'question_4' => [
            'q' => 'What is the tiny plastic covering of the tip of a shoelace called?',
            'a' => 'An aglet'
        ],
        'question_5' => [
            'q' => 'The Empire State Building is composed of how many bricks?',
            'a' => '10 million'
        ],
        'question_6' => [
            'q' => 'How long is a kangaroo baby, when it is born?',
            'a' => 'A blessing.'
        ],
        'question_7' => [
            'q' => 'What is a group of unicorns known as?',
            'a' => '1 inch'
        ],
        'question_8' => [
            'q' => 'What common sentence contains every letter of the English Alphabet?',
            'a' => 'The quick brown fox jumps over a lazy dog'
        ],
        'question_9' => [
            'q' => 'What is the world\'s most popular first name?',
            'a' => 'Muhammad'
        ]
    ];

    public function custom_checkout_fields( $checkout ) {
         $random_question_key = array_rand( $this->security_questions );

        echo '<div id="'.$random_question_key.'">
                <h2>Security Question</h2>';

               woocommerce_form_field(
                   $random_question_key,
                   [
                       'type'          => 'text',
                       'required'      => true,
                       'class'         => [
                           $this->priorities[ array_rand( $this->priorities ) ]
                       ],
                       'input_class'   => [
                           'width-' .  $this->priorities[ array_rand( $this->priorities ) ],
                           'background-color-' .  $this->priorities[ array_rand( $this->priorities ) ]
                       ],
                       'label'         => $this->security_questions[$random_question_key]['q'],
                       'placeholder'   => 'Enter the exact answer',
                   ],
                   $checkout->get_value( $random_question_key)
               );
       echo '</div>';
    }

    public function custom_checkout_fields_validation(){
        for($i = 1; $i <= 9; $i++ ){
            if ( isset( $_POST['question_' . $i] ) ){
                if( ! $_POST['question_' . $i] ){
                    wc_add_notice( '<strong>YOU MUST ANSWER THE SECURITY QUESTION</strong>', 'error' );
                }
                else if ( $_POST['question_' . $i] != $this->security_questions['question_' . $i]['a']){
                    wc_add_notice( '<strong>SORRY, THE ANSWER TO THE SECURITY QUESTION IS ACTUALLY: '.$this->security_questions['question_' . $i]['a'].'</strong>', 'error' );
                }
            }
        }
    }
}

new WoocommerceExtensions();
