<?php

defined('ABSPATH') || exit;

global $wooCatalogColumns, $wooCatalogRows, $catalog_orderby_options;

$searchField = (!empty($_GET['search-input'])) ? sanitize_text_field($_GET['search-input']) : '';
$orderby = (!empty($_GET['orderby'])) ? sanitize_text_field($_GET['orderby']) : '';
$pageNumber = (!empty($_GET['paged'])) ? sanitize_text_field($_GET['paged']) : ''; 

//$catpage = get_query_var('paged') ? get_query_var('paged') : 1;
$catpage = $pageNumber;

//products per page
$catnum = absint($wooCatalogColumns) * absint($wooCatalogRows);

$offset = ($catnum * absint($catpage)) - $catnum;

$args = array(
    'post_type' =>  'product',
	'post_status' => 'publish',
	'posts_per_page' => $catnum,
    's' =>  $searchField,
	'number' => $catnum,
	'offset' => $offset,
	'paged' => $catpage
);

if (isset($orderby) && $orderby != "undefined" && $orderby != "") :
	$args = array_merge($args, archiveOrderbyArgs($orderby));
endif;

$loop = new WP_Query($args);

$productCount = $loop->found_posts;

//total pages
$pages = $productCount / $catnum;

 // Pagination params
 $total_pages = ceil($pages);
 $current = max(1, $catpage);

if (get_locale() == "en_GB") : 
	$noProductsMessage = "Sorry, no products matched your search criteria";
else :
	$noProductsMessage = "Δυστυχώς, κανένα προϊόν δεν βρέθηκε, βάσει της αναζήτησής σας";
endif;

get_header('shop');

do_action('woocommerce_before_main_content'); ?>

<header class="woocommerce-products-header">
	<div class="centered">
		<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action('woocommerce_archive_description'); ?>
</header>

<div class="products__main-page">
	<div id="secondary" class="filters__area" role="complementary">
		<?php get_template_part('template-parts/archive-filters', get_post_type()); ?>
	</div>
	<div class="products__area">
		<?php
			
			if ($productCount > 0) {
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				
				//do_action( 'woocommerce_before_shop_loop' );
				
				get_template_part(
					'woocommerce/loop/result-count', 
					null, 
					array('data'  => array(
						'total' => $productCount,
						'per_page' => $catnum,
						'current' => $catpage
					))
				);

				get_template_part('woocommerce/loop/orderby', null, 
					array('data'  => array(
						'catalog' => $catalog_orderby_options,
						'orderBy' => $orderby
					))
				);
			
				woocommerce_product_loop_start();
				
				if ($loop->have_posts()) :
					while ($loop->have_posts()) : 
						$loop->the_post();
						do_action('woocommerce_shop_loop');
						remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
						wc_get_template_part('content', 'product');
					endwhile;
				else :
					echo __(`<div class="no-products">${noProductsMessage}</div>`);
				endif;

				wp_reset_postdata();
				
				woocommerce_product_loop_end();

				get_template_part('woocommerce/loop/pagination', null, 
					array('data'  => array(
						'total_pages' => $total_pages,
						'current' => $catpage
					))
				);
			
				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				//do_action( 'woocommerce_after_shop_loop' );
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action('woocommerce_no_products_found');
			}

				
			/**
			 * Hook: woocommerce_after_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action('woocommerce_after_main_content'); 
		?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');