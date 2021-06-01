<?php

// Remove unwanted HTML margin top 32px.
function my_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
} 
add_action('get_header', 'my_filter_head');

// Add SVG and webP support functionality
function mime_types($mimes) {
	$mimes['svg'] = 'image/svg';
	$mimes['webp'] = 'image/webp';
  	return $mimes;
}
add_filter('upload_mimes', 'mime_types');

// Use custom logo in login screen
function custom_login_logo() {
    if (has_custom_logo()) : $image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full'); ?>
        <style type="text/css">
            .login h1 a {
                background-image: url(<?php echo esc_url($image[0]); ?>);
                background-size: auto;
				width: 100%;
            }
        </style>
    <?php endif;
}
add_action('login_head', 'custom_login_logo', 100);

// Add theme support to dashboard area
function custom_dashboard_widget() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}
add_action('wp_dashboard_setup', 'custom_dashboard_widget');
 
function custom_dashboard_help() {
	echo '<p>Welcome to Calisthenics Theme! Need help? <br>Contact the developer <a href="mailto:daino92@gmail.com">here</a>.</p>';
}

// Modifying image attributes of gallery images and post thumbnails
function lazyload_post_thumbnail_attr($attr, $attachment, $size) {
    if (isset($attr['sizes'])) {
           $data_sizes = $attr['sizes'];
           unset($attr['sizes']);
           $attr['data-sizes'] = $data_sizes;
    }
 
    if (isset($attr['srcset'])) {
           $data_srcset = $attr['srcset'];
           unset($attr['srcset']);
           $attr['data-srcset']   = $data_srcset;
           $attr['data-noscript'] = $attr['src'];
           //unset($attr['src']);
           $attr['src'] = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
    }
    $attr['class'] .= ' lazyload blur-up';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'lazyload_post_thumbnail_attr', 20, 3);

 // Noscript element for post thumbnails
function lazyload_responsive_images_filter_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    foreach ($dom->getElementsByTagName('img') as $img) {
       $src     = $img->getAttribute('data-noscript');
       $classes = $img->getAttribute('class');
       $alt 	 = $img->getAttribute('alt');
    }
    $noscript_element = "<noscript><img src='" . $src . "' class='" . $classes . "' alt='" . $alt . "'></noscript>";
    $html .= $noscript_element;
    return $html;
}
add_filter('post_thumbnail_html', 'lazyload_responsive_images_filter_post_thumbnail_html', 10, 5);

// Remove type attribute from CSS and JS files
function remove_type_attribute() {
	ob_start(function ($buffer) {
		return preg_replace("%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer);
	});
}
add_action('template_redirect', 'remove_type_attribute');

// Modify Gravatar image
function modify_gravatar($attr) {
    $attr = str_replace("class='avatar", "class='avatar lazyload", $attr);
   	//$attr = str_replace('srcset', 'data-srcset', $attr);
    $attr = str_replace('src', 'data-src', $attr);

	return $attr;
}
add_filter('get_avatar','modify_gravatar', 10, 5);

// Add title and alt for Gravatar
if(!is_admin()) {
	function gravatar_alt($gravatar) {
		if (have_comments()) {
			$alt = get_comment_author();
		}
		else {
			$alt = get_the_author_meta('display_name');
		}
		$gravatar = str_replace('alt=\'\'', 'alt=\'Avatar for ' . $alt . '\' title=\'Gravatar for ' . $alt . '\'', $gravatar);
		return $gravatar;
	}
	add_filter('get_avatar', 'gravatar_alt');
}

// Hide Wordpress versionn
remove_action('wp_head', 'wp_generator');

// Stop heartbeat (admin-ajax.php)
function stop_heartbeat() {
	wp_deregister_script('heartbeat');
}
add_action('init', 'stop_heartbeat', 1);

// Disable Self Pingback
function disable_pingback(&$links) {
	foreach ($links as $l => $link)
 		if (0 === strpos($link, get_option('home')))
 			unset($links[$l]);
}
add_action('pre_ping', 'disable_pingback');

// Remove WLManifest Link
remove_action('wp_head', 'wlwmanifest_link');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove RSD-link
remove_action('wp_head', 'rsd_link');

// Disable Embeds
function disable_embed(){
	wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'disable_embed');

// Remove the REST API endpoint.
remove_action('rest_api_init', 'wp_oembed_register_route');
 
// Turn off oEmbed auto discovery.
add_filter('embed_oembed_discover', '__return_false');
 
// Don't filter oEmbed results.
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
 
// Remove oEmbed discovery links.
remove_action('wp_head', 'wp_oembed_add_discovery_links');
 
// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action('wp_head', 'wp_oembed_add_host_js');

// Remove Shortlink
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Disable Emoticons
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove Query Strings
function remove_cssjs_ver($src) {
	if (strpos($src, '?ver=')) $src = remove_query_arg('ver', $src);
	return $src;
}
add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);

// Remove api.w.org relation link
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

// Disable WordPress Help in Admin menu
function disable_help_adminLink() {
    if(is_admin()){
    	echo '<style type="text/css"> #contextual-help-link-wrap { display: none !important; } </style>';
    }
}
add_action('admin_head', 'disable_help_adminLink');

// Disable the message - JQMIGRATE: Migrate is installed, version 1.4.1
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});