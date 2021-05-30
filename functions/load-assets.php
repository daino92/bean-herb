<?php

function asset_version() {
	global $asset_version;

	if (wp_get_environment_type() == "production") {
		$asset_version = 'min.';
	} else {
		$asset_version = '';
	}
}
add_action('after_setup_theme', 'asset_version');

function wpb_hook_javascript() {  
	global $asset_version; ?>
	
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
			"<?php echo get_template_directory_uri() . '/resources/js/lazysizes.min.js'?>",
			"<?php echo get_template_directory_uri() . '/dist/scripts/custom.js'?>",
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

	//if (!current_user_can('update_core')) {
		//wp_deregister_script('jquery');
		//wp_dequeue_style('wp-block-library');	// gutenberg plugin
	//}

	// if (is_page_template('thank-you_template.php')) {
	// 	wp_enqueue_style('thank-you', get_template_directory_uri() . "/dist/styles/thankyou.${asset_version}css?v=" . wp_get_theme()->get('Version'), array(), null);
	// }

	// if ((!is_null($post) && $post->post_type == "wpm-testimonial")	|| 
	// 	(is_category() && !in_category(['vg','vg-el'])) || is_single()) {
	// 	wp_enqueue_style('general-pages', get_template_directory_uri() . "/dist/styles/general-pages.${asset_version}css?v=" . wp_get_theme()->get('Version'), array(), null);
	// }

	//if (is_404()) {
		//wp_enqueue_style('404-css', get_template_directory_uri() . "/dist/styles/404.${asset_version}css?v=" . wp_get_theme()->get('Version'), array(), null);
	//}
}
add_action('wp_enqueue_scripts', 'load_per_page');