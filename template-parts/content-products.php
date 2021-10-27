<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

// collect and organize meta fields
$meta_fields = array();

$post_metas = array(
        'product_price',
        'product_sale_price',
        'product_on_sale',
        'youtube_video',
        'product_description'
);
foreach($post_metas as $meta){
    $meta_fields[$meta] = get_custom_field($meta);
}

// add gallery images to meta field array
$meta_fields['gallery'] = array();
for($i = 1; $i<=6; $i++){
    $this_gallery_field = 'gal_custom_image' . $i;
    $meta_fields['gallery'][] = get_custom_field($this_gallery_field);
}

// is product on sale?
if($meta_fields['product_on_sale'] == "yes") $on_sale_class = 'on-sale';
else $on_sale_class = '';



// Get Related Posts
$main_post_id = get_the_ID();
$product_category_data = get_the_terms( get_the_ID(), 'product_categories' );   // what categor is this post in?

if(isset($product_category_data) && $product_category_data != '') {
    $product_category_slug = $product_category_data[0]->slug;
    $product_category_name = $product_category_data[0]->name;
}

// query for other posts in this category
$the_query = new WP_Query( array(
    'post_type' => 'products',
    'post__not_in' => array($main_post_id),
    'tax_query' => array(
        array (
            'taxonomy' => 'product_categories',
            'field' => 'slug',
            'terms' => $product_category_slug,
        )
    ),
) );

// if found, get the data of the related post
$relatedPosts = false;
if ( $the_query->have_posts() ) {
    $relatedPosts = true;
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $related_prod_title = get_the_title();
        $related_prod_link = get_the_permalink();
    }
}
/* Restore original Post Data */
wp_reset_postdata();
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php

    get_template_part( 'template-parts/entry-header' );

    if ( ! is_search() ) {
        get_template_part( 'template-parts/featured-image' );
    }

    ?>

    <div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

        <div class="entry-content">

            <p><?php echo $meta_fields['product_description'] ?></p>
            <p>
                <?php echo show_youtube_embed($meta_fields['youtube_video']) ?>
                <?php //echo show_youtube_embed('https://www.youtube.com/embed?v=WqD-ATqw3js') ?>



            </php>
            <h4>
                <span class="single-meta-title">Price: </span> <!-- Price Title -->
                <span class="<?php echo $on_sale_class ?>">$<?php echo $meta_fields['product_price'] ?></span>  <!-- Regular Price -->
                <?php if($meta_fields['product_on_sale'] == "yes") echo "$" . $meta_fields['product_sale_price'] ?>  <!-- Sale Price, if Relevant -->
            </h4>

            <?php if ( isset($meta_fields['gallery']) ) { ?>   <!-- Show the Product Image Gallery  -->
            <h3> Product Image Gallery</h3>
            <div class="product-image-gallery">
                <?php
                    foreach($meta_fields['gallery'] as $count => $src){
                        if($src) echo show_gallery_image($count, $src);
                    }
                ?>
            <div>
            <?php } ?>

        </div><!-- .entry-content -->

    </div><!-- .post-inner -->

    <?php if( $relatedPosts ) {  // showrealted posts if there are ?>

            <nav class="pagination-single section-inner<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'twentytwenty' ); ?>" role="navigation">

                <hr class="styled-separator is-style-wide" aria-hidden="true" />
                <h4>More Posts From... <?php echo $product_category_name ?> </h4>
                <div class="pagination-single-inner">

                    <a class="previous-post" href="<?php echo $related_prod_link ?>">
                        <span class="title"><span class="title-inner"><?php  echo $related_prod_title ?></span></span>
                    </a>

                </div><!-- .pagination-single-inner -->

                <hr class="styled-separator is-style-wide" aria-hidden="true" />

            </nav><!-- .pagination-single -->
    <?php } ?>

</article><!-- .post -->
