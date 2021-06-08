<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Bean_&_Herb
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function bean_herb_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'bean_herb_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function bean_herb_woocommerce_scripts() {
	wp_enqueue_style('bean-herb-woocommerce-style', get_template_directory_uri() . '/dist/styles/woocommerce.css', array(), _S_VERSION);

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style('bean-herb-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'bean_herb_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function bean_herb_woocommerce_active_body_class($classes) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter('body_class', 'bean_herb_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function bean_herb_woocommerce_related_products_args($args) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args($defaults, $args);

	return $args;
}
add_filter('woocommerce_output_related_products_args', 'bean_herb_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('bean_herb_woocommerce_wrapper_before')) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function bean_herb_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action('woocommerce_before_main_content', 'bean_herb_woocommerce_wrapper_before');

if (!function_exists('bean_herb_woocommerce_wrapper_after')) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function bean_herb_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action('woocommerce_after_main_content', 'bean_herb_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if (function_exists('bean_herb_woocommerce_header_cart')) {
			bean_herb_woocommerce_header_cart();
		}
	?>
 */

if (!function_exists('bean_herb_woocommerce_cart_link_fragment')) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function bean_herb_woocommerce_cart_link_fragment($fragments) {
		ob_start();
		bean_herb_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();
		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'bean_herb_woocommerce_cart_link_fragment');

if (!function_exists('bean_herb_woocommerce_cart_link')) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function bean_herb_woocommerce_cart_link() { ?>
		<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'bean-herb'); ?>">
			<svg>
				<use xlink:href="#cart"></use>
			</svg>
			<span class="count">
				<?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
			</span>
		</a>
		<?php
	}
}

if (!function_exists('bean_herb_woocommerce_header_cart')) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function bean_herb_woocommerce_header_cart() {
		if (is_cart()) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		} ?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php bean_herb_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
					$instance = array(
						'title' => '',
					);

					the_widget('WC_Widget_Cart', $instance); 
				?>
			</li>
		</li>
		<?php
	}
}

// Remove add to cart button from archive-product.php and single-product.php
function remove_add_to_cart_buttons() {
	if (is_product_category() || is_shop() || is_product()) {
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	}
}
add_action('woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1);

// Remove breadcrumbs
function remove_shop_breadcrumbs() {
	if (is_product_category() || is_shop() || is_product()) remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}
add_action('template_redirect', 'remove_shop_breadcrumbs');

function add_percentage_to_sale_badge($html, $post, $product) {
    if ($product->is_type('variable')) {
        $percentages = array();

        // Get all variation prices
        $prices = $product->get_variation_prices();

        // Loop through variation prices
        foreach ($prices['price'] as $key => $price) {
            // Only on sale variations
            if ($prices['regular_price'][$key] !== $price) {
                // Calculate and set in the array the percentage for each variation on sale
                $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
            }
        }
        $percentage = max($percentages) . '%';
    } else {
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();

        $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
    }
    return '<span class="dis">' . esc_html__('', 'woocommerce') . ' ' . $percentage . '</span>';
}
add_filter('woocommerce_sale_flash', 'add_percentage_to_sale_badge', 20, 3);

function woocommerce_custom_single_add_to_cart_text() {
	if (get_locale() == "en_GB") :
		return __('Basket', 'woocommerce');
	else :
		return __('Καλάθι', 'woocommerce');
	endif;
}
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');

/*
*  Content below "Add to cart" Button.
*/
function add_to_wishlist_btn_in_simple_product() {
	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}
add_action('woocommerce_after_add_to_cart_button', 'add_to_wishlist_btn_in_simple_product');

// Notify admin when a new customer account is created
function woocommerce_created_customer_admin_notification($customer_id) {
	wp_send_new_user_notifications($customer_id, 'admin');
}
add_action('woocommerce_created_customer', 'woocommerce_created_customer_admin_notification');


// Modify product link a tag with URL decode
function product_link_open() {
	echo '<a href="'. urldecode(get_the_permalink()) .'" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
}
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10); 
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
add_action('woocommerce_before_shop_loop_item', 'product_link_open', 10);

// Modify product thumbail, adding h2 title inside
function woocommerce_get_product_thumbnail($size = 'shop_catalog') {
	global $post, $woocommerce;
	//$output = '<div class="col-lg-4">';

	if (has_post_thumbnail()) {               
		$output = get_the_post_thumbnail($post->ID, $size);
	} else {
		$output = wc_placeholder_img($size);
	}  
	$output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';                     
	//$output .= '</div>';
	return $output;
}

add_action('init', function() {
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_get_product_thumbnail', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_get_product_thumbnail', 10);
});