<?php

function product_box_shortcode($atts) {
    $args = shortcode_atts(
        array(
        'productid' => '1',
        'bgcolor' => 'red',
        ), $atts
    );
    // read atts into variables
    $productid = $args['productid'];
    $bgcolor = $args['bgcolor'];

    // query other post info
    $title = get_the_title($productid);
    $price = get_custom_field('product_price', $productid);
    $image = get_the_post_thumbnail_url($productid, array(300,300) );


    $output_string = "
    <div class='shortcode-box' style='text-align:center; padding: 5px 20px; background-color:".$bgcolor."'>
        <h2>".$title."</h2>
        <img src='".$image."'>
        <h3>Price: $".$price."</h3>
    </div>
    ";
    return $output_string;
    wp_reset_postdata();

}
add_shortcode('product_box', 'product_box_shortcode');