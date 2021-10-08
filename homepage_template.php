<?php /* Template Name: homepage template  */ ?>

<?php
/**
 * The template for displaying the home page of this site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

get_header(); ?>

<div id="primary" class="content-area homepage">
	<main id="main" class="site-main">
		<?php if (have_posts()) :
			get_template_part('template-parts/homepage/frontpage-banner', get_post_type());
			get_template_part('template-parts/homepage/product-categories', get_post_type());
			get_template_part('template-parts/homepage/purple-banner', get_post_type());
			get_template_part('template-parts/homepage/product-loop', get_post_type(), array('data' => array('productType' => "popular")));
			get_template_part('template-parts/homepage/product-loop', get_post_type(), array('data' => array('productType' => "offers"))); 
			get_template_part('template-parts/homepage/featuring', get_post_type());
			get_template_part('template-parts/homepage/product-loop', get_post_type(), array('data' => array('productType' => "new")));
			get_template_part('template-parts/homepage/orange-banner', get_post_type());
			get_template_part('template-parts/homepage/gift-proposals', get_post_type());
			get_template_part('template-parts/homepage/gift-creation', get_post_type());
			get_template_part('template-parts/homepage/eshop-featuring', get_post_type());
			get_template_part('template-parts/homepage/insta-newsletter', get_post_type());
		endif; ?>
	</main>
</div>

<?php get_footer();