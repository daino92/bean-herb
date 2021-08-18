<?php

function asset_version() {
	global $assetVersion;

	if (wp_get_environment_type() == "production") {
		$assetVersion = 'min.';
	} else {
		$assetVersion = '';
	}
}
add_action('after_setup_theme', 'asset_version');

function wpb_hook_javascript() {  
	global $assetVersion; ?>
	
    <script>
		//Load CSS/JS Files
		var scriptIndex = 0;
		function loadCSS(src){
		    var style = document.createElement('link');
		    style.rel = 'stylesheet';
		    style.href = src;
		    var head = document.getElementsByTagName('link')[0];
		    head.parentNode.insertBefore(style, head);
		};
	 
		var scriptOrder = [
			"https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js",
			"<?php echo get_template_directory_uri() . "/resources/js/lazysizes.min.js"?>",
			"<?php echo get_template_directory_uri() . "/dist/scripts/custom${assetVersion}.js"?>"
	   	]; 
	
		function loadScript() {      
		   	if(scriptIndex < scriptOrder.length){ 
		     	var element = document.createElement('script');
		     	element.src = scriptOrder[scriptIndex];              
		     	element.onload = function(){
	        		scriptIndex++;
	               	loadScript();
	        	};     
	      	 	document.body.appendChild(element);     	 	
			}
		}

		function CSSOnReady(){
			//loadCSS('<?php //echo get_template_directory_uri() . "/dist/styles/slick-slider.${asset_version}css"?>');
		}
	
		function CSSOnLoad() {
			//loadCSS("https://unpkg.com/aos@2.3.1/dist/aos.css");
		} 

		if (document.addEventListener) {
			document.addEventListener("DOMContentLoaded", loadScript, false); 
			document.addEventListener("DOMContentLoaded", CSSOnReady, false);
		} else if (document.attachEvent){
			document.attachEvent("DOMContentLoaded", loadScript);
			document.attachEvent("DOMContentLoaded", CSSOnReady);
		} else {
			document.onready = JSOnReady;	
			document.onready = CSSOnReady;
		}
		if (window.addEventListener) window.addEventListener("load", CSSOnLoad);
		else if (window.attachEvent) window.attachEvent("load", CSSOnLoad);
		else window.onload = CSSOnLoad;
	</script>
    <?php
}
add_action('wp_footer', 'wpb_hook_javascript');

function load_per_page() {
	global $post;
	global $asset_version;

	// echo "<pre>"; 
	// var_dump($post); 
	// echo "</pre>";

	if (!current_user_can('update_core')) {
		wp_dequeue_style('wp-block-library');	// gutenberg plugin
		wp_dequeue_style('wc-block-style'); 	// woocommerce block style
		wp_dequeue_style('wc-block-editor'); 	// wocoommerce block editor
	}

	/** * Global dequeues / deregisters * **/

    // contact-form-7
	wp_dequeue_style('contact-form-7');
    wp_dequeue_script('contact-form-7');

	// woo variation watches
	wp_dequeue_style('woo-variation-swatches'); 
	wp_dequeue_style('woo-variation-swatches-theme-override');   
	wp_dequeue_style('woo-variation-swatches-tooltip');
	wp_dequeue_script('woo-variation-swatches');

	// YITH wishlist
	wp_dequeue_style('jquery-selectBox');
	wp_dequeue_style('yith-wcwl-font-awesome');
	wp_dequeue_style('yith-wcwl-main');
	wp_dequeue_style('yith-wcwl-theme');
	wp_dequeue_script('jquery-selectBox');
	wp_dequeue_script('jquery-yith-wcwl');

	if (is_product() || yith_wcwl_is_wishlist_page()) {
		wp_enqueue_style('jquery-selectBox');
		wp_enqueue_style('yith-wcwl-font-awesome');
		wp_enqueue_style('yith-wcwl-main');
		wp_enqueue_style('yith-wcwl-theme');
		wp_enqueue_style('jquery-selectBox');
		wp_enqueue_style('jquery-yith-wcwl');
	}

	if (is_page_template('contactTemplate.php')) {
		wp_enqueue_style('contact-form-7');		
		wp_enqueue_script('contact-form-7');	
	}
}
add_action('wp_enqueue_scripts', 'load_per_page', 16);