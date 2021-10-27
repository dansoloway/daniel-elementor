<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

    <header class="page-header alignwide">
        <h1 class="page-title"><?php single_post_title(); ?></h1>
    </header><!-- .page-header -->

<?php
$args = array(
    'post_type' => 'products',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'orderby' => 'title',
    'order' => 'ASC',
    );

    $posts = new WP_Query( $args );
    $sorted_products = array();
    while ( $posts->have_posts() ) {
        //dumpData($post);

        $posts->the_post();

        $local_array = array();
        $local_array['id'] = $post->ID;
        $local_array['title'] = $post->post_title;
        $local_array['image'] = get_the_post_thumbnail_url($post->ID, array(400, 400));
        $local_array['slug'] = $post->post_name;
        $local_array['sale'] = get_post_meta( $post->ID, $key = 'product_on_sale', $single = true );

        $sorted_products[] = $local_array;
    }

    wp_reset_postdata();
    //dumpData($sorted_products);

    $sale_badge = '<span class="sale-badge">Sale!</span>';
?>

<main id="site-content">
    <div class="page-header">
        <h1>Games!</h1>
    </div>
    <div class="product-container">
        <?php
        foreach($sorted_products as $prod){ ?>
            <div class="one-product">
                <a href="<?php echo get_permalink($prod['id'])?>">
                <img src="<?php echo $prod['image']?>">
                 <?php if($prod['sale'] == "yes") echo $sale_badge ?>

                <h2><?php echo $prod['title'] ?></h2>
                </a>
            </div>

        <?php
        }
        ?>

    </div>
</main>
<?php
get_footer();
