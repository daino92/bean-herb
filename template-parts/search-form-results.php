<?php

defined('ABSPATH') || exit;

$searchField = (!empty($_GET['search-input'])) ? sanitize_text_field($_GET['search-input']) : '';

$per_page = 9;
$current = 1;
$orderBy = "menu-order";

$catalog_orderby_options = apply_filters('woocommerce_catalog_orderby', array( 
    'menu_order' => __('Default sorting', 'woocommerce'),  
    'popularity' => __('Sort by popularity', 'woocommerce'),  
    'rating' => __('Sort by average rating', 'woocommerce'),  
    'date' => __('Sort by newness', 'woocommerce'),  
    'price' => __('Sort by price: low to high', 'woocommerce'),  
    'price-desc' => __('Sort by price: high to low', 'woocommerce'),  
)); 

$args = array(
    'post_type' =>  'product',
	'post_status' => 'publish',
	'posts_per_page' => $per_page,
    's' =>  $searchField
);

$loop = new WP_Query($args);

$total = $loop->found_posts;

if (get_locale() == "en_GB") : 
	$noProductsMessage = "Sorry, no products matched your search criteria";
else :
	$noProductsMessage = "Δυστυχώς, κανένα προϊόν δεν βρέθηκε, βάσει της αναζήτησής σας";
endif;

// echo "<pre>"; 
// var_dump($args);
// echo "</pre>";
//wc_get_template_part('archive', 'product');

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
					'total' => $total,
					'per_page' => $per_page,
					'current' => $current
				))
			);

			get_template_part('woocommerce/loop/orderby', null, 
				array('data'  => array(
					'catalog' => $catalog_orderby_options,
					'orderBy' => $orderBy
				))
			); ?>
		
			<?php woocommerce_product_loop_start();
            
            if ($loop->have_posts()) :
                while ($loop->have_posts()) : 
                    $loop->the_post();
                    do_action( 'woocommerce_shop_loop' );
                    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
                    wc_get_template_part('content', 'product');
                endwhile;
            else :
                echo __(`<div class="no-products">${noProductsMessage}</div>`);
            endif;

            wp_reset_postdata();
            
            woocommerce_product_loop_end();
			
			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		

		/**
		 * Hook: woocommerce_after_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' ); ?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );