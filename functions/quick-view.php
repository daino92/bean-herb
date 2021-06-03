<?php

if (!defined('ABSPATH')) die();

if (class_exists('QuickViewWooProduct', false)) {
    QuickViewWooProduct::getInstance();
    return;
}

class QuickViewWooProduct {
    //region Singleton
    /** @var QuickViewWooProduct */
    private static $instance;

    /** @return QuickViewWooProduct */
    public static function getInstance(){
        if (QuickViewWooProduct::$instance == null)
            QuickViewWooProduct::$instance = new QuickViewWooProduct();
        return QuickViewWooProduct::$instance;
    }

    /** @return QuickViewWooProduct */
    private function __construct(){
        $this->init();
    }
    //endregion

    public function init() {
        if (is_plugin_active('woocommerce/woocommerce.php')) {
            add_action('wp_enqueue_scripts', [$this, 'QuickView_enqueues']);

            add_action('wp_ajax_nopriv_QuickView__action', array($this,'QuickView__action_ajax_cb'));
            add_action('wp_ajax_QuickView__action', array($this, 'QuickView__action_ajax_cb'));

            add_action('woocommerce_before_shop_loop_item_title', [$this, 'QuickView__add_btn'], 20);
            add_action('wp_footer', [$this, 'QuickView__popup'], 20);
        }
    }

    function QuickView_enqueues() {
        if (current_theme_supports('wc-product-gallery-zoom')) wp_enqueue_script('zoom');
        if (current_theme_supports('wc-product-gallery-slider')) wp_enqueue_script('flexslider');

        if (current_theme_supports('wc-product-gallery-lightbox')) {
            wp_enqueue_script('photoswipe-ui-default');
            wp_enqueue_style('photoswipe-default-skin');
            add_action('wp_footer', 'woocommerce_photoswipe');
        }
        wp_enqueue_script('wc-add-to-cart-variation');
        wp_enqueue_script('wc-single-product');
    }

    function QuickView__action_ajax_cb() {
        if (empty($_REQUEST['id'])) {
            echo 'Invalid product selection!';
            die;
        }
        $id = $_REQUEST['id'];
        echo $this->QuickView_render($id);
        die;
    }

    function QuickView_render($id) {
        if (empty($id)) return '';
        
        $atts = array();

        $atts['id'] = $id;

        if (!isset($atts['id']) && !isset($atts['sku'])) {
            return '';
        }

        $args = array(
            'posts_per_page'      => 1,
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'no_found_rows'       => 1,
        );

        if (isset($atts['id'])) {
            $args['p'] = absint($atts['id']);
        }

        // Don't render titles if desired.
        if (isset($atts['show_title']) && !$atts['show_title']) {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        }

        $single_product = new \WP_Query($args);

        $preselected_id = '0';

        // For "is_single" to always make load comments_template() for reviews.
        $single_product->is_single = true;

        ob_start();

        global $wp_query;

        // Backup query object so following loops think this is a product page.
        $previous_wp_query = $wp_query;
        // @codingStandardsIgnoreStart
        $wp_query          = $single_product;
        // @codingStandardsIgnoreEnd

        // remove related products
        remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);
        
        // remove product tabs
        add_filter('woocommerce_product_tabs', '__return_empty_array', 98);

        while ($single_product->have_posts()) :
            $single_product->the_post() ?>
            <div class="single-product clearfix" data-product-page-preselected-id="<?php echo esc_attr($preselected_id); ?>">
                <?php wc_get_template_part('content', 'single-product'); ?>
            </div>
            <?php
        endwhile;

        // Restore $previous_wp_query and reset post data.
        // @codingStandardsIgnoreStart
        $wp_query = $previous_wp_query;
        // @codingStandardsIgnoreEnd
        wp_reset_postdata();

        // Re-enable titles if they were removed.
        if (isset($atts['show_title']) && !$atts['show_title']) {
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        }

        add_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);

        return '<div class="woocommerce">' . ob_get_clean()
            . "<script>
            jQuery('.woocommerce-product-gallery').each(function(){if(jQuery.isFunction(jQuery.fn.wc_product_gallery)){jQuery(this).wc_product_gallery();}});
            jQuery(document).find('#productPopup').find('li#tab-title-description a').click();            
            jQuery(document).find('#productPopup').find('.variations_form select').change();
            if(jQuery.isFunction(jQuery.fn.wc_variation_form)){jQuery(document).find('#productPopup').find('.variations_form').wc_variation_form();};
            </script>"
            . '</div>';
    }

    function QuickView__add_btn(){
        global $product; ?>

        <div class="quick-view__btn">
            <a class="button quick-view__open-single-product" data-id="<?php echo $product->get_id(); ?>" href="#">
                <?php echo __('Quick view'); ?>
            </a>
        </div> 
    <?php }

    function QuickView__popup() { ?>
        <div id="productModal" class="modal popup" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
            <div class="modal-content"></div>
        </div>
    <?php }
}

QuickViewWooProduct::getInstance();