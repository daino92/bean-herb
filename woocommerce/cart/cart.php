<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="shopping-cart__wrapper">
	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action('woocommerce_before_cart_table'); ?>

		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
				<tr>
					<th class="product-remove"></th>
					<th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
					<th class="product-thumbnail"></th>
					<th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
					<th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
					<th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php do_action('woocommerce_before_cart_contents'); ?>

				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key); ?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
							<td class="product-remove">
								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
											esc_url(wc_get_cart_remove_url( $cart_item_key)),
											esc_html__('Remove this item', 'woocommerce'),
											esc_attr($product_id),
											esc_attr($_product->get_sku())
										),
										$cart_item_key
									);
								?>
							</td>

							<td class="product-thumbnail">
								<?php $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

								if (!$product_permalink) {
									echo $thumbnail; // PHPCS: XSS ok.
								} else {
									printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
								} ?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
								<?php if (!$product_permalink) {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
								} else {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
								}

								do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

								// Backorder notification.
								if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
								} ?>
							</td>

							<td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
								<?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok. ?>
							</td>

							<td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce' ); ?>">
								<?php
								if ($_product->is_sold_individually()) {
									$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok. ?>
							</td>

							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
								<?php
									echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
								?>
							</td>
						</tr>
						<?php
					}
				}

				do_action('woocommerce_cart_contents'); ?>

				<tr class="woocommerce-cart-form__cart-actions">
					<td colspan="6" class="actions">
						<div class="cart--footer">
							<?php if (wc_coupons_enabled()) { ?>
								<div class="coupon">
									<!-- <label for="coupon_code">
										<?php //esc_html_e('Coupon:', 'woocommerce'); ?>
									</label>  -->
									<span class="wc-coupon-field">
										<label for="coupon_code">
											<?php //esc_html_e('Coupon:', 'woocommerce'); ?>
										</label> 
										<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
											<path d="M576 448q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm1067 576q0 53-37 90l-491 492q-39 37-91 37-53 0-90-37l-715-716q-38-37-64.5-101t-26.5-117v-416q0-52 38-90t90-38h416q53 0 117 26.5t102 64.5l715 714q37 39 37 91z" fill="#fff"/>
										</svg>
										<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
									</span>
									<button type="submit" class="button btn__apply-discount" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
									<?php do_action('woocommerce_cart_coupon'); ?>
								</div>
							<?php } ?>

							<!-- <button type="submit" class="button" name="update_cart" value="<?php //esc_attr_e('Update cart', 'woocommerce'); ?>"><?php //esc_html_e('Refresh cart', 'woocommerce'); ?></button> -->
							<span class="update-cart-button">
								<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
									<path d="M1639 1056q0 5-1 7-64 268-268 434.5t-478 166.5q-146 0-282.5-55t-243.5-157l-129 129q-19 19-45 19t-45-19-19-45v-448q0-26 19-45t45-19h448q26 0 45 19t19 45-19 45l-137 137q71 66 161 102t187 36q134 0 250-65t186-179q11-17 53-117 8-23 30-23h192q13 0 22.5 9.5t9.5 22.5zm25-800v448q0 26-19 45t-45 19h-448q-26 0-45-19t-19-45 19-45l138-138q-148-137-349-137-134 0-250 65t-186 179q-11 17-53 117-8 23-30 23h-199q-13 0-22.5-9.5t-9.5-22.5v-7q65-268 270-434.5t480-166.5q146 0 284 55.5t245 156.5l130-129q19-19 45-19t45 19 19 45z" fill="#fff"/>
								</svg>
								<input type="submit" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"/>
							</span>
							<?php 
								do_action('woocommerce_cart_actions');

								wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); 
							?>
						</div>
					</td>
				</tr>

				<?php do_action('woocommerce_after_cart_contents'); ?>
			</tbody>
		</table>
		<?php do_action('woocommerce_after_cart_table'); ?>
	</form>

	<?php do_action('woocommerce_before_cart_collaterals'); ?>

	<div class="cart-collaterals">
		<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action('woocommerce_cart_collaterals');
		?>
	</div>
</div>

<?php do_action('woocommerce_after_cart'); ?>

