<?php

require_once('woocommerce-extensions.php');

if(!defined('THEME_DIR')) {
     define('THEME_DIR', get_stylesheet_directory() .'/');
}
if(!defined('THEME_URL')) {
    define('THEME_URL', get_stylesheet_directory_uri() .'/' );
}

//style.css is left empty because I don't want to have to empty my browser cache to see CSS changes
function enqueue_theme_styles(){
   $css = 'theme.css';
   $cache_bust = '?v='.filemtime(THEME_DIR . $css);
   wp_enqueue_style( 'theme-css', THEME_URL . $css . $cache_bust, array(), NULL );
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 999);


function enqueue_theme_scripts() {
   global $post;

   $js = 'theme.js';
   $cache_bust = '?v='.filemtime(THEME_DIR . $js);

   $script_location = THEME_URL  . $js . $cache_bust;


   wp_enqueue_script(
       'theme-js',
       $script_location,
       [ 'jquery' ],
       false,
       true
   );
}

add_action('wp_enqueue_scripts', 'enqueue_theme_scripts', 999);
