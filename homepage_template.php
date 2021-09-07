<?php /* Template Name: homepage template  */ ?>

<?php
/**
 * The template for displaying the home page of this site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

get_header();
$base_dir = get_template_directory_uri(); ?>

<div id="primary" class="content-area homepage">
	<main id="main" class="site-main">
		<?php if (have_posts()) :
			get_template_part('template-parts/frontpage-banner', get_post_type());
			get_template_part('template-parts/product-categories', get_post_type());
			get_template_part('template-parts/purple-banner', get_post_type());
			get_template_part('template-parts/product-loop', get_post_type(), array('data' => array('productType' => "popular")));
			get_template_part('template-parts/product-loop', get_post_type(), array('data' => array('productType' => "offers"))); 
			get_template_part('template-parts/featuring', get_post_type());
			get_template_part('template-parts/product-loop', get_post_type(), array('data' => array('productType' => "new")));
			get_template_part('template-parts/orange-banner', get_post_type());
			get_template_part('template-parts/gift-proposals', get_post_type());
			get_template_part('template-parts/gift-creation', get_post_type());
			get_template_part('template-parts/eshop-featuring', get_post_type());
			get_template_part('template-parts/insta-newsletter', get_post_type());
		endif; ?>
	</main>
</div>

<?php get_footer();