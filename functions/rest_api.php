<?php
/*
This is a very simple Endpoint, hard-coded to work only with Products Custom Post Type.
In a real world scenario I would build it out a lot more, but I am running out of time :)

You can access it here:
http://localhost/elementor/wp-json/twenty-twenty-child/v1/products


*/

add_action('rest_api_init', function () {
    register_rest_route( 'twenty-twenty-child/v1', 'products',array(
        'methods'  => 'GET',
        'callback' => 'rest_get_products'
    ));
});

function rest_get_products($request){
    $args = array(
        'post_type' => 'products',
        'numberposts' => -1,
    );
    $posts = get_posts($args);
    if (empty($posts)) {
        return new WP_Error('empty_category', 'There are no posts to display', array('status' => 404));
    }

    $ret_array = array();
    foreach($posts as $post){
        $localArray = array();
        $localArray['product_title'] = $post->post_title;
        $localArray['product_price'] = get_custom_field('product_price', $post->ID);
        $localArray['product_sale_price'] = get_custom_field('product_sale_price', $post->ID);
        $localArray['product_on_sale'] = get_custom_field('product_on_sale', $post->ID);
        $localArray['product_description'] = get_custom_field('product_description', $post->ID);
        $localArray['product_image'] = get_the_post_thumbnail_url($post->ID);
        $ret_array[] = $localArray;
    }
//    dumpData($ret_array);
    $response = json_encode($ret_array);

    return $response;
}