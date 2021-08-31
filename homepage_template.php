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
			get_template_part('template-parts/product-categories', get_post_type()); ?>

			<div class="purple-bg">
				<div class="purple-bg__content">
					<div class="purple-bg__content--left">
						<div class="lazyload blur-up" style="background: url('<?= $base_dir; ?>/resources/images/papas.png')"></div>
					</div>
					<div class="purple-bg__content--right">
						<div class="lazyload blur-up" style="background: url('<?= $base_dir; ?>/resources/images/logo.png')"></div>
						<div class="content-message">
							<?php if (get_locale() == "en_GB") : ?>
								We carefully choose our products <br> from certified producers from <br> Greece and the whole world
							<?php else : ?>
								Eπιλέγουμε τα καλύτερα <br> προϊόντα από εγκεκριμένους <br> παραγωγούς απ΄ όλο τον κόσμο
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php get_template_part('template-parts/product-loop', get_post_type(), array('data' => array('product_type' => "popular")));
			get_template_part('template-parts/product-loop', get_post_type(), array('data' => array('product_type' => "new-products")));
			get_template_part('template-parts/product-loop', get_post_type(), array('data' => array('product_type' => "offers")));

			get_template_part('template-parts/insta-newsletter', get_post_type());
		endif; ?>
	</main>
</div>

<?php get_footer();