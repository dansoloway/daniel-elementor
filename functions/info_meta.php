<?php
add_action( 'add_meta_boxes', 'products_add_metabox', 'high', 1 );
function products_add_metabox() {

    add_meta_box(
        'create_products_meta_box',
        'Product Information',
        'create_products_meta_box_callback',
        'products',
        'normal',
        'high' 
    );

}

function create_products_meta_box_callback( $post ) {

    $product_price_db = get_post_meta( $post->ID, 'product_price', true );
    $product_sale_price_db = get_post_meta( $post->ID, 'product_sale_price', true );
    $product_on_sale_db = get_post_meta( $post->ID, 'product_on_sale', true );
    $youtube_video_db = get_post_meta( $post->ID, 'youtube_video', true );
    $product_description_db = get_post_meta( $post->ID, 'product_description', true );

    $product_category_db = get_the_terms( $post->ID, 'product_categories' );
    if(isset($product_category_db) && $product_category_db != '') $product_category_db = $product_category_db[0]->term_id;



    // query product category terms
    $product_cat_terms = get_terms( array(
        'taxonomy' => 'product_categories',
        'hide_empty' => false,
    ) );

    // reorgainze product category array
    $product_cat_array = array();
    foreach($product_cat_terms as $prod_cat){
        $localArray = array();
        $localArray['name'] = $prod_cat->name;
        $localArray['term_id'] = $prod_cat->term_id;
        $product_cat_array[] = $localArray;
    }

    //build product cat select list
    $product_cat_select_list = '';
    foreach ($product_cat_array as $prod_cat) {
        $this_selected = selected( $prod_cat['term_id'], $product_category_db, false );
        $product_cat_select_list.= '<option value="'.$prod_cat['name'].'" ' . $this_selected  . '>'.$prod_cat['name'].'</option>';
    }
    
    // none
    wp_nonce_field( 'infometanonce', '_infosafe' );

    //dumpData(get_post_meta($post->ID));

    echo '<table class="form-table">
		<tbody>
			
			<tr>
				<th><label for="product_description">Description</label></th>
				<td><textarea id="product_description" name="product_description" class="regular-text"> ' . esc_attr( $product_description_db ) . ' </textarea></td>
			</tr>
			
			<tr>
				<th><label for="product_price">Price</label></th>
				<td><input type="text" id="product_price" name="product_price" value="' . esc_attr( $product_price_db ) . '" class="regular-text"></td>
			</tr>
			
			<tr>
				<th><label for="product_sale_price">Sale Price</label></th>
				<td><input type="text" id="product_sale_price" name="product_sale_price" value="' . esc_attr( $product_sale_price_db ) . '" class="regular-text"></td>
			</tr>
			
			<tr>
				<th><label for="product_on_sale">Is on sale?</label></th>
				<td>
					<select id="product_on_sale" name="product_on_sale" required>
						<option value="">Select...</option>
						<option value="yes"' . selected( 'yes', $product_on_sale_db, false ) . '>Yes</option>
						<option value="no"' . selected( 'no', $product_on_sale_db, false ) . '>No</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<th><label for="product_categories_dropdown">Category</label></th>
				<td>
					<select id="product_categories_dropdown" name="product_categories_dropdown" required>
						<option value="">Select...</option>
						'.$product_cat_select_list.'
					</select>
				</td>
			</tr>
			
			<tr>
				<th><label for="youtube_video">Youtube Video</label></th>
				<td><input type="text" id="youtube_video" name="youtube_video" value="' . esc_attr( $youtube_video_db ) . '" class="regular-text"></td>
			</tr>
		</tbody>
		
		
	</table>';

}add_action( 'save_post', 'products_save_meta_box', 10, 2 );

function products_save_meta_box( $post_id, $post ) {
    // nonce check
    if ( ! isset( $_POST[ '_infosafe' ] ) || ! wp_verify_nonce( $_POST[ '_infosafe' ], 'infometanonce' ) ) {
        return $post_id;
    }

    // check current use permissions
    $post_type = get_post_type_object( $post->post_type );


    if( $post->post_type != 'products' ) {
        return $post_id;
    }

    $posted_fields = array('product_price','product_sale_price','youtube_video','product_on_sale');
    foreach($posted_fields as $posted_field){
        if( isset( $_POST[ $posted_field] ) ) {
            update_post_meta( $post_id, $posted_field, sanitize_text_field( $_POST[ $posted_field] ) );
        } else {
            delete_post_meta( $post_id, $posted_field);
        }
    }

    // update Product Category
    if( isset( $_POST['product_categories_dropdown'] ) ) {
        $selected_val = sanitize_text_field( $_POST['product_categories_dropdown']);
        $setTerms = wp_set_object_terms( $post_id, $selected_val, 'product_categories', false);
    } else {
        $setTerms = wp_set_object_terms( $post_id, '', 'product_categories', false);
    }

    // update Product Description

    if( isset( $_POST['product_description'] ) ) {
        update_post_meta( $post_id, 'product_description', sanitize_textarea_field( $_POST['product_description'] ) );
    } else {
        delete_post_meta( $post_id, 'product_description');
    }

    return $post_id;

}