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
			get_template_part('template-parts/frontpage-banner', get_post_type());
			get_template_part('template-parts/popular-products', get_post_type());
			get_template_part('template-parts/new-products', get_post_type());
			get_template_part('template-parts/offer-products', get_post_type());
		endif; ?>
	</main>
</div>

<?php get_footer();