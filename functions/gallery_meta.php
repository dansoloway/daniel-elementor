<?php
function gal_custom_meta_boxes( $post_type, $post ) {
    add_meta_box(
        'gal-meta-box',
        'Gallery Images',
        'render_gal_meta_box',
        'products', //post types here
        'normal',
        'low'
    );
}
add_action( 'add_meta_boxes', 'gal_custom_meta_boxes', 'low', 2 );

function show_gallery_image($key, $url ){
    $ret = "<div class='product-image-container'>";
    $ret.= '<img src="' . $url . '" alt="' . get_the_title() . ' Product Image ' . $key . '">';
    $ret.= "</div>";
    return $ret;
}

function get_custom_field($field_name, $id = 'default' ){
    if($id == "default") $post_id = get_the_ID();
    else $post_id = $id;
    return get_post_meta($post_id, $field_name,true);
}


function render_gal_meta_box($post) {

    $placeholder_img = get_stylesheet_directory_uri() . "/img/placeholder.png";
    $images = array();   // show image gallery
    for($i = 1; $i<=6; $i++) {
        $key = 'gal_custom_image' . $i;
        $images[$i] = get_post_meta($post->ID, $key, true);
    }

    ?>
    <table>
        <?php
        for($i = 1; $i<=6; $i++){
            if($images[$i]) {
                $image_src = $images[$i];
                $hidden = "";
            }
            else {
                $image_src = $placeholder_img;
                $hidden = "hidden";
            }
        ?>
        <tr>
            <td>
                <h3>Image <?php echo $i ?></h3>
                <a href="#" id="upload_image_button<?php echo $i ?>" class="gal_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></td>
            <td>
                <input type="hidden" name="gal_custom_image<?php echo $i ?>" id="gal_custom_image<?php echo $i?>" value="<?php echo $images[$i]; ?>" />
                <div class="adminImagePreview" style="width:200px">
                    <img  id="adminImagePreview<?php echo $i?>" style="max-width:100%" src="<?php echo $image_src ?>">
                </div>
            </td>
            <td class="<?php echo $hidden ?>" id="delete_button<?php echo $i ?>">
                <a href="#"
                   data-id="<?php the_ID() ?>"
                   data-nonce="<?php echo wp_create_nonce('delete_gal_image_nonce') ?>"
                   data-image="<?php echo $i ?>"
                   class="delete_admin_image button button-secondary"><?php _e('Delete Image'); ?>
                </a>

            </td>
        </tr>

        <?php } ?>
    </table>
    <?php
}

add_action('save_post', 'gal_save_postdata');
function gal_save_postdata($post_id)
{
    for($i = 1; $i<=6; $i++){
        $key = "gal_custom_image" . $i;
        if (array_key_exists($key, $_POST)) {
            $updatePost = update_post_meta(
                $post_id,
                $key,
                $_POST[$key]
            );
        }
    }


}


add_action( 'wp_ajax_delete_gal_image', 'delete_gal_image' );
function delete_gal_image()
{
    $permission = check_ajax_referer('delete_gal_image_nonce', 'nonce', false);
    if ($permission == false) {
        echo 'error';
    } else {
        delete_post_meta($_REQUEST['id'], $_REQUEST['image']);

        echo 'success';
    }
}