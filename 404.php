<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bean_&_Herb
 */

get_header(); 

if (get_locale() == "en_GB") : 
	$products = 'Products';
else :
    $products = 'Προϊόντα';
endif; ?>

	<main id="primary" class="site-main">
		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title">
					<?php esc_html_e('Oops! That page can&rsquo;t be found.', 'bean-herb'); ?>
				</h1>
			</header>

			<div class="page-content">
				<p>
					<?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below?', 'bean-herb'); ?>
				</p>
				<div class="flex">
					<a class="btn" href="<?= esc_url(home_url('/')) ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
					<a class="btn" href="<?= urldecode(wc_get_page_permalink('shop')) ?>"><?= $products; ?></a>
				</div>

					<?php //get_search_form(); ?>

					<!-- <div class="widget widget_categories">
						<h2 class="widget-title"><?php //esc_html_e( 'Most Used Categories', 'bean-herb' ); ?></h2>
						<ul>
							<?php
							// wp_list_categories(
							// 	array(
							// 		'orderby'    => 'count',
							// 		'order'      => 'DESC',
							// 		'show_count' => 1,
							// 		'title_li'   => '',
							// 		'number'     => 10,
							// 	)
							// );
							?>
						</ul>
					</div> -->

					<?php
					/* translators: %1$s: smiley */
					//$bean_herb_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'bean-herb' ), convert_smilies( ':)' ) ) . '</p>';
					//the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$bean_herb_archive_content" );

					//the_widget( 'WP_Widget_Tag_Cloud' );
					?>
			</div>
		</section>
	</main>

<?php get_footer();