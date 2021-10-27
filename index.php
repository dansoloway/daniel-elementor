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
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">
    <header class="archive-header has-text-align-center header-footer-group">

        <div class="archive-header-inner section-inner medium">

          <h2>What Do You Want To Do?</h2>
            <ul class="user-actions">
                <li><a href="<?php echo get_site_url() . "/products" ?>">View Products</a></li>
                <li>Create a Post with a shortcode [product_box productid=  bgcolor= ] </a></li>
                <li>Override the Shortcode with <strong>?soldout=1</strong> </a></li>
                <li><a href="<?php echo get_site_url() . "/wp-json/twenty-twenty-child/v1/products" ?>">Make an API request</a></li>


            </ul>

        </div><!-- .archive-header-inner -->

    </header><!-- .archive-header -->
</main>
<?php
get_footer();
