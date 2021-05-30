<?php

function ajaxCallJS() {
    $ajaxUrl = admin_url('admin-ajax.php');
    $baseDir = get_template_directory_uri();
    //global $asset_version;

    wp_register_script('ajax-calls', get_template_directory_uri() . "/dist/scripts/ajax-calls.js");
    wp_localize_script('ajax-calls', 'ajax', array(
        'ajaxUrl' => $ajaxUrl,
        'baseDir' => $baseDir
    ));
    wp_enqueue_script('ajax-calls');
}
add_action('wp_enqueue_scripts', 'ajaxCallJS');
//add_action('admin_enqueue_scripts', 'ajaxCallJS');

// Query woocommerce columns and rows
global $wpdb;
$wooCatalogColumnsQuery = "SELECT * FROM $wpdb->options WHERE option_name = 'woocommerce_catalog_columns'";
$wooCatalogRowsQuery = "SELECT * FROM $wpdb->options WHERE option_name = 'woocommerce_catalog_rows'";
$wooCatalogColumns = $wpdb->get_results($wooCatalogColumnsQuery, OBJECT)[0]->option_value; 
$wooCatalogRows = $wpdb->get_results($wooCatalogRowsQuery, OBJECT)[0]->option_value; 

function archiveResultCount($productCount, $catnum, $currentPage = 1) {
    $message = "";

    if (0 === intval($productCount)) :
        if (get_locale() == "en_GB") : 
            $message = "No result";
        else :
            $message = "Κανένα αποτελέσμα";
        endif;
    elseif (1 === intval($productCount)) :
        if (get_locale() == "en_GB") : 
            $message = "Showing the single result";
        else :
            $message = "Εμφάνιση του μοναδικού αποτελέσματος";
        endif;
    elseif ($productCount <= $catnum || -1 === $catnum) :
        if (get_locale() == "en_GB") : 
            $message = "Showing all ${productCount} results";
        else :
            $message = "Βλέπετε όλων των ${productCount} αποτελεσμάτων.";
        endif;
    else :
        $first = ($catnum * $currentPage) - $catnum + 1;
        $last  = min($productCount, $catnum * $currentPage);
        if (get_locale() == "en_GB") : 
            $message = "Showing ${first}-${last} of ${productCount} result";
        else :
            $message = "Βλέπετε ${first}-${last} από ${productCount} αποτέλεσματα";
        endif;
    endif;

    return $message;
}

function archiveOrderbyArgs($orderby) {
	switch ($orderby) {
        case 'price':
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'asc'; 
        break;

        case 'price-desc':
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'desc'; 
        break;

        case 'date':
            $args['meta_key'] = '';
            $args['orderby'] = 'date';
            $args['order'] = 'desc'; 
        break;

        case 'title':
            $args['meta_key'] = '_woocommerce_product_short_title';
            $args['orderby'] = 'meta_value';
            $args['order'] = 'asc';

        case 'sku': 
            $args['meta_key'] = '_sku';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'asc';
        break;
            
        case 'popularity':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'asc';
        break;

        case 'rating':
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'desc';
        break;

        default :
            $args['meta_key'] = '';    
            $args['orderby'] = 'menu_order title';
            $args['order'] = 'asc';
    }
    return $args;
}

$catalog_orderby_options = apply_filters('woocommerce_catalog_orderby', array( 
    'menu_order' => __('Default sorting', 'woocommerce'),  
    'popularity' => __('Sort by popularity', 'woocommerce'),  
    'rating' => __('Sort by average rating', 'woocommerce'),  
    'date' => __('Sort by newness', 'woocommerce'),  
    'price' => __('Sort by price: low to high', 'woocommerce'),  
    'price-desc' => __('Sort by price: high to low', 'woocommerce'),  
)); 

// Product ordering section construct
function getUpperContent($productCount, $catnum, $pageNumber, $orderby, $catpage) {
    global $catalog_orderby_options;

    $result_count .= '<p class="woocommerce-result-count">';
    $result_count .= archiveResultCount($productCount, $catnum, $pageNumber);
    $result_count .= '</p>';
    
    $order_by .= '<form class="woocommerce-ordering" method="get">';
    $order_by .= '<select name="orderby" class="orderby" aria-label="' . esc_attr('Shop order', 'woocommerce') . '">';
    foreach ($catalog_orderby_options as $id => $name) : 
        $order_by .= '<option value="' . esc_attr($id) .'"' . selected($orderby, $id, false) . '>';
        $order_by .= esc_html($name); 
        $order_by .= '</option>';
    endforeach; 
    $order_by .= '</select>';
    $order_by .= '<input type="hidden" name="paged" value="' . $catpage . '" />';
    $order_by .= '</form>';

    $wrapperUpperContent .= '<div class="products__ordering">';
        $wrapperUpperContent .= $result_count;
        $wrapperUpperContent .= $order_by;
    $wrapperUpperContent .= '</div>';

    return $wrapperUpperContent;
}

function getPagination($total, $current) {
    if ($total > 1) {    
        $pagination .= "<nav class='woocommerce-pagination paginator'>";
        $pagination .= paginate_links(
            apply_filters(
                'woocommerce_pagination_args',
                array( // WPCS: XSS ok.
                    'base'      => esc_url_raw(str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999, false)))),
                    'format'    => '?paged=%#%',
                    'add_args'  => false,
                    'current'   => max(1, $current),
                    'total'     => $total,
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type'      => 'plain',
                    'end_size'  => 3,
                    'mid_size'  => 3,
                )
            )
        );
        $pagination .= "</nav>";
    }

    return $pagination;
}

// product link URI
function getProductLinkURI($slug) {
    if (isset($slug) && $slug != "" && $slug != "undefined") :
        $productLinkURI .= 'product-category/' . $slug . '/';
    else :
        if (get_locale() == "en_GB") : 
            $productLinkURI = '/en/shop/';
        else : 
            $productLinkURI = '/κατάστημα';
        endif;
    endif;

    return $productLinkURI;
}

function totalProducts(){
    $totalProductsArgs = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1);
    $totalProducts = count(get_posts($totalProductsArgs));
    return $totalProducts;
}

/**
 * AJAX Callbacks
 * Custom ajax category filtering in archive-page.php
 */
function filter__categories_ajax_cb() {
    global $wooCatalogColumns, $wooCatalogRows, $catalog_orderby_options;

    $original_REQUEST_URI = $_SERVER['REQUEST_URI'];
    $slug = (!empty($_POST['slug'])) ? sanitize_text_field($_POST['slug']) : '';
    $productCount = (!empty($_POST['productCount'])) ? absint($_POST['productCount']) : '';
    $orderby = (!empty($_POST['orderby'])) ? sanitize_text_field($_POST['orderby']) : '';

    $catpage = get_query_var('paged') ? get_query_var('paged') : 1;

    //products per page
    $catnum = absint($wooCatalogColumns) * absint($wooCatalogRows);
    
    $offset = ($catnum * $catpage) - $catnum;
    
    if ($slug == "") {
        $productCount = totalProducts();
    }

    //total pages
    $pages = $productCount / $catnum;

    // Pagination params
    $total = ceil($pages);
    $current = max(1, $catpage);

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $catnum,
        'number' => $catnum,
        'offset' => $offset,
        'paged' => $catpage
    );

    if (isset($orderby) && $orderby != "undefined" && $orderby != "") {
        $args = array_merge($args, archiveOrderbyArgs($orderby));
    }
 
    if (isset($slug) && $slug != "undefined") {
        $args['product_cat'] = $slug;
    }

    getProductLinkURI($slug);

    $wrapperUpperContent = getUpperContent($productCount, $catnum, 1, $orderby, $catpage);

    // Overwrite the REQUEST_URI variable
    $_SERVER['REQUEST_URI'] = $productLinkURI;

    $loop = new WP_Query($args);

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : 
            $loop->the_post();
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            $products = wc_get_template_part('content', 'product');
        endwhile;
    else :
        $products =  __('<div class="no-products">Sorry, no products matched your search criteria</div>');
    endif;
    
    wp_reset_postdata();
    
    $pagination = getPagination($total, $current);

    // Restore the original REQUEST_URI 
    $_SERVER['REQUEST_URI'] = $original_REQUEST_URI;

    $response = $products . $pagination . $wrapperUpperContent;

    echo $response;

    wp_die();
}
add_action('wp_ajax_nopriv_filter__categories', 'filter__categories_ajax_cb');
add_action('wp_ajax_filter__categories', 'filter__categories_ajax_cb');

/**
 * AJAX Callbacks
 * Ajax pagination in archive-page.php
 */
function ajax__pagination_cb() {
    global $wooCatalogColumns, $wooCatalogRows, $catalog_orderby_options;

    $original_REQUEST_URI = $_SERVER['REQUEST_URI'];
    $slug = (!empty($_POST['slug'])) ? sanitize_text_field($_POST['slug']) : '';
    $productCount = (!empty($_POST['productCount'])) ? absint($_POST['productCount']) : '';
    $pageNumber = (!empty($_POST['pageNumber'])) ? absint($_POST['pageNumber']) : '';
    $orderby = (!empty($_POST['orderby'])) ? sanitize_text_field($_POST['orderby']) : '';

    $catpage = $pageNumber;

    //products per page
    $catnum = absint($wooCatalogColumns) * absint($wooCatalogRows);

    $offset = ($catnum * $catpage) - $catnum;

    if ($slug == "" || $slug == "undefined") {
        $productCount = totalProducts();
    }

    //total pages
    $pages = $productCount / $catnum;

    // Pagination params
    $total = ceil($pages);
    $current = max(1, $catpage);

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $catnum,
        'number' => $catnum,
        'offset' => $offset,
        'paged' => $catpage
    );
 
    if (isset($slug) && $slug != "undefined") {
        $args['product_cat'] = $slug;
    }

    if (isset($orderby) && $orderby != "undefined" && $orderby != "") {
        $args = array_merge($args, archiveOrderbyArgs($orderby));
    }

    getProductLinkURI($slug);

    $wrapperUpperContent = getUpperContent($productCount, $catnum, $pageNumber, $orderby, $catpage);

    // Overwrite the REQUEST_URI variable
    $_SERVER['REQUEST_URI'] = $productLinkURI;

    $loop = new WP_Query($args);

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : 
            $loop->the_post();
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            $products = wc_get_template_part('content', 'product');
        endwhile;
    else :
        $products =  __('<div class="no-products">Sorry, no products matched your search criteria</div>');
    endif;

    wp_reset_postdata();
    
    $pagination = getPagination($total, $current);

    $response = $products . $pagination . $wrapperUpperContent;

    echo $response;

    // Restore the original REQUEST_URI 
    $_SERVER['REQUEST_URI'] = $original_REQUEST_URI;

    wp_die();
}
add_action('wp_ajax_nopriv_ajax__pagination', 'ajax__pagination_cb');
add_action('wp_ajax_ajax__pagination', 'ajax__pagination_cb');

/**
 * AJAX Callbacks
 * Ajax orderby in archive-page.php
 */
function ajax__οrderΒy_cb() {
    global $wooCatalogColumns, $wooCatalogRows, $catalog_orderby_options;

    $original_REQUEST_URI = $_SERVER['REQUEST_URI'];
    $slug = (!empty($_POST['slug'])) ? sanitize_text_field($_POST['slug']) : '';
    $orderby = (!empty($_POST['orderby'])) ? sanitize_text_field($_POST['orderby']) : '';
    $productCount = (!empty($_POST['productCount'])) ? absint($_POST['productCount']) : '';
    $pageNumber = (!empty($_POST['pageNumber'])) ? absint($_POST['pageNumber']) : '';

    $catpage = $pageNumber;

    //products per page
    $catnum = absint($wooCatalogColumns) * absint($wooCatalogRows);

    $offset = ($catnum * $catpage) - $catnum;

    if ($slug == "" || $slug == "undefined") {
        $productCount = totalProducts();
    }

    //total pages
    $pages = $productCount / $catnum;

    // Pagination params
    $total = ceil($pages);
    $current = max(1, $catpage);

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $catnum,
        'number' => $catnum,
        'offset' => $offset,
        'paged' => $catpage
    );

    // echo "<pre>"; 
    // var_dump($args);
    // echo "</pre>";
 
    if (isset($slug) && $slug != "undefined") {
        $args['product_cat'] = $slug;
    }

    if (isset($orderby) && $orderby != "undefined" && $orderby != "") {
        $args = array_merge($args, archiveOrderbyArgs($orderby));
    }

    getProductLinkURI($slug);

    $wrapperUpperContent = getUpperContent($productCount, $catnum, $pageNumber, $orderby, $catpage);

    // Overwrite the REQUEST_URI variable
    $_SERVER['REQUEST_URI'] = $productLinkURI;

    $loop = new WP_Query($args);

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : 
            $loop->the_post();
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            $products = wc_get_template_part('content', 'product');
        endwhile;
    else :
        $products =  __('<div class="no-products">Sorry, no products matched your search criteria</div>');
    endif;

    wp_reset_postdata();

    $pagination = getPagination($total, $current);

    $response = $products . $pagination . $wrapperUpperContent;

    echo $response;

    // Restore the original REQUEST_URI 
    $_SERVER['REQUEST_URI'] = $original_REQUEST_URI;

    wp_die();
}
add_action('wp_ajax_nopriv_ajax__οrderΒy', 'ajax__οrderΒy_cb');
add_action('wp_ajax_ajax__οrderΒy', 'ajax__οrderΒy_cb');

/**
 * AJAX Callbacks
 * Ajax search field in archive-page.php
 */
function ajax__searchField_cb() {
    global $wooCatalogColumns, $wooCatalogRows, $catalog_orderby_options;

    $original_REQUEST_URI = $_SERVER['REQUEST_URI'];
    $searchField = (!empty($_POST['searchField'])) ? sanitize_text_field($_POST['searchField']) : '';
    $orderby = (!empty($_POST['orderby'])) ? sanitize_text_field($_POST['orderby']) : '';

    $catpage = get_query_var('paged') ? get_query_var('paged') : 1;;

    //products per page
    $catnum = absint($wooCatalogColumns) * absint($wooCatalogRows);

    $offset = ($catnum * $catpage) - $catnum;
    
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $catnum,
        's' =>  $searchField,
        'number' => $catnum,
        'offset' => $offset,
        'paged' => $catpage
    );
    
    // echo "<pre>"; 
    // var_dump($args);
    // echo "</pre>";

        
    // if (isset($orderby) && $orderby != "undefined" && $orderby != "") {
        //     $args = array_merge($args, archiveOrderbyArgs($orderby));
        // }
            
    //getProductLinkURI($slug);
    
    
    // Overwrite the REQUEST_URI variable
    $_SERVER['REQUEST_URI'] = $productLinkURI;
    
    $loop = new WP_Query($args);
    
    $productCount = $loop->found_posts;

    //total pages
    $pages = $productCount / $catnum;

    // Pagination params
    $total = ceil($pages);
    $current = max(1, $catpage);
    
    $wrapperUpperContent = getUpperContent($productCount, $catnum, $catpage, $orderby, $catpage);

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : 
            $loop->the_post();
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            $products = wc_get_template_part('content', 'product');
        endwhile;
    else :
        $products =  __('<div class="no-products">Sorry, no products matched your search criteria</div>');
    endif;

    wp_reset_postdata();

    $pagination = getPagination($total, $current);

    $response = $products . $pagination . $wrapperUpperContent;

    echo $response;

    // Restore the original REQUEST_URI 
    $_SERVER['REQUEST_URI'] = $original_REQUEST_URI;

    wp_die();
}
add_action('wp_ajax_nopriv_ajax__searchField', 'ajax__searchField_cb');
add_action('wp_ajax_ajax__searchField', 'ajax__searchField_cb');