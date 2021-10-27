<?php
add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
function enqueue_styles() {
    wp_enqueue_style('parent-theme', get_template_directory_uri() .'/style.css');
    wp_enqueue_style('child-theme', get_stylesheet_directory_uri() .'/style.css');

}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );
function enqueue_admin_scripts(){
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery'), null, false );
    wp_localize_script( 'custom-js', 'MyAjaxObj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) , 'placeholderimg' => get_stylesheet_directory_uri() . '/img/placeholder.png' ) );

    wp_enqueue_style( 'admin-css', get_stylesheet_directory_uri() . '/css/admin.css');
}

add_action( 'wp_loaded','hide_admin_bar_elem_user' );
function hide_admin_bar_elem_user(){
    $currentUser = get_current_user_id();
    if($currentUser == 2) add_filter('show_admin_bar', '__return_false');
}


function dumpData($data, $die = false){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    if($die) die("Output Stopped");
}

require_once(get_stylesheet_directory() . "/functions/types.php");  // register custom post type and taxonomy
require_once(get_stylesheet_directory() . "/functions/gallery_meta.php");   // photo gallery Meta Box
require_once(get_stylesheet_directory() . "/functions/info_meta.php");   // Product Info Meta Box
require_once(get_stylesheet_directory() . "/functions/display_product.php");   // Display product to user
require_once(get_stylesheet_directory() . "/functions/shortcode.php");   //
