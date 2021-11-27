<?php
/**
* Simple product add to cart
*
* This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce/Templates
* @version 3.4.0
*/

defined('ABSPATH') || exit;

global $product, $wpdb;

$productId = $product->get_id();
$price = $product->get_price();

$productQuery = "SELECT * FROM $wpdb->postmeta WHERE post_id = $productId AND meta_key = '_wc_price_calculator'";
$resultsProduct = $wpdb->get_results($productQuery, OBJECT); 

if ($resultsProduct) :
	$priceCalculatorInfo = unserialize($resultsProduct[0]->meta_value);
	$pricingUnit = $priceCalculatorInfo["weight"]["pricing"]["unit"];
	$calculatorType = $priceCalculatorInfo["calculator_type"];
	$productΑttributes = $priceCalculatorInfo["weight"]["weight"]["input_attributes"];
	
	if ($pricingUnit == "g") :
		$minPrice = $price;
	else :
		$minPrice = ($price * $productΑttributes["min"]) / 1000;
		$minPrice = number_format($minPrice, 2);
	endif;
endif;

// dd($pricingUnit);

if (get_locale() == "en_GB") : 
	$unit = "gr.";
	$unit_label = "Choose weight in ";
	$pieces_label = "Pieces";
else :
	$unit = "γρ.";
	$unit_label = "Επιλέξτε βάρος σε ";
	$pieces_label = "Τεμάχια";
endif;

if (!$product->is_purchasable()) return;

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

	<div class="flex-product-icons">
		<?php
			$upload_dir = wp_upload_dir();
			$base_url = $upload_dir["baseurl"] . "/product-icons";
			$regex = '/product-icon-.*[0-9]$/';

			foreach(get_post_meta($productId) as $key => $val) :
				foreach($val as $vals) :
					if (preg_match($regex, $key)) echo "<img class='individual-icon' src='$base_url/${vals}.png' alt='${vals}'/>";
				endforeach;
			endforeach; 
		?> 
	</div>
	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', urldecode($product->get_permalink()))); ?>" method="post" enctype='multipart/form-data'>
		<?php 
			if(isset($calculatorType) && $calculatorType != "") : ?>
				<div id="price_calculator">
					<div style="text-align: center"><?php echo $unit_label, $unit; ?>:</div>
					<div class="flex">
						<input type="hidden" name="minimum__weight" value=<?php echo $productΑttributes["min"]; ?> />
						<input type="hidden" name="unit" value="<?php echo $unit; ?>" />
						<input type="hidden" name="pricingUnit" value="<?php echo $pricingUnit; ?>" />
						<input type="hidden" id="initial__price" value="<?php echo $price ?>" />
						<input type="hidden" name="weight_needed" value="<?php echo $productΑttributes["min"]; ?>" />
						<input type="hidden" id="_measurement_needed" name="_measurement_needed" value="" />
						<input type="hidden" id="_measurement_needed_unit" name="_measurement_needed_unit" value="" />
						<button type="button" class="quantity-control" id="minus">-</button>
						<input type="text" id="weight_needed" class="quantity-input" 
							value="<?php echo $minPrice . " € / " . $productΑttributes["min"], $unit ?>"
							data-min="<?php echo $productΑttributes["min"]; ?>" 
							data-step="<?php echo $productΑttributes["step"]; ?>" 
							data-current-step="<?php echo $productΑttributes["min"]; ?>">
						<button type="button" class="quantity-control" id="plus">+</button>
					</div>
				</div>
			<?php endif; ?>

		<div class="quantity-label"><?php echo $pieces_label; ?></div>
		<div class="quantity-pieces">
			<?php do_action('woocommerce_before_add_to_cart_quantity'); ?>

			<div class="flex quantity-section">
				<button type="button" class="quantity-control" id="minus_pieces">-</button>
				<input id="quantity-pieces" type="text" class="quantity-input" step="1" min="1" value="1" name="quantity" title="Qty">
				<button type="button" class="quantity-control" id="plus_pieces">+</button>
			</div>

			<?php do_action('woocommerce_after_add_to_cart_quantity'); ?>

			<div class="flex cart-wishlist">
				<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt">
					<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
						<path d="M704 1536q0 52-38 90t-90 38-90-38-38-90 38-90 90-38 90 38 38 90zm896 0q0 52-38 90t-90 38-90-38-38-90 38-90 90-38 90 38 38 90zm128-1088v512q0 24-16.5 42.5t-40.5 21.5l-1044 122q13 60 13 70 0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-11 8-31.5t16-36 21.5-40 15.5-29.5l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t19.5 15.5 13 24.5 8 26 5.5 29.5 4.5 26h1201q26 0 45 19t19 45z" fill="#fff"/>
					</svg>
					<?php echo esc_html($product->single_add_to_cart_text()); ?>
				</button>

				<?php do_action('woocommerce_after_add_to_cart_button'); // Add to wishlist ?>	
			</div>
		</div>
	</form>

	<?php do_action('woocommerce_after_add_to_cart_form');
endif; ?>