<?php

add_action( 'init', 'create_product_posttype' );
function create_product_posttype() {

    register_post_type( 'products',

        array(
            'labels' => array(
                'name'                  => _x( 'Products', 'Post type general name'),
                'singular_name'         => _x( 'Product', 'Post type singular name'),
                'menu_name'             => _x( 'Products', 'Admin Menu text'),
                'name_admin_bar'        => _x( 'Product', 'Add New on Toolbar'),
                'add_new'               => __( 'Add New'),
                'add_new_item'          => __( 'Add New Product'),
                'new_item'              => __( 'New Product'),
                'edit_item'             => __( 'Edit Product'),
                'view_item'             => __( 'View Product'),
                'all_items'             => __( 'All Products'),
                'search_items'          => __( 'Search Products'),
                'parent_item_colon'     => __( 'Parent Products:'),
                'not_found'             => __( 'No Products found.'),
                'not_found_in_trash'    => __( 'No Products found in Trash.'),
                'taxonomies'            => array('product_categories'),
                'featured_image'        => _x( 'Product  Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3'),
                'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3'),
                'archives'              => _x( 'Product archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4'),
                'uploaded_to_this_item' => _x( 'Uploaded to this Product', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4'),
                'filter_items_list'     => _x( 'Filter Products list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4'),
                'items_list_navigation' => _x( 'Products list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4'),
                'items_list'            => _x( 'Products list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'products'),
            'show_in_rest' => true,
//            'rest_base' => 'products',
//            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title', 'thumbnail'),
        )
    );
}

//hook into the init action and call create_book_taxonomies when it fires

add_action( 'init', 'create_product_category_taxonomy', 0 );
function create_product_category_taxonomy() {
    $labels = array(
        'name' => _x( 'Product Categories', 'taxonomy general name' ),
        'singular_name' => _x( 'Product Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Product Categories' ),
        'all_items' => __( 'All Product Categories' ),
        'edit_item' => __( 'Edit Product Category' ),
        'update_item' => __( 'Update Product Category' ),
        'add_new_item' => __( 'Add New Product Category' ),
        'new_item_name' => __( 'New Product Category Name' ),
        'menu_name' => __( 'Product Categories' ),
    );

// Now register the taxonomy
    register_taxonomy('product_categories',array('products'), array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'product_categories' ),
        'show_in_quick_edit'         => true,
        'meta_box_cb'                => false,
    ));

}