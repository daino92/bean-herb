<?php

// Create Social media URLs Settings
function custom_settings_add_menu() {
	add_options_page('Social media URLs', 'Social media URLs', 'manage_options', 'social-media-urls', 'social_media_settings_page', null, 99);
}
add_action('admin_menu', 'custom_settings_add_menu');

function social_media_settings_page_setup() {
	add_settings_section('section', null, null, 'theme-options');

	add_settings_field('facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'section');
	add_settings_field('instagram', 'Instagram URL', 'setting_instagram', 'theme-options', 'section');
	add_settings_field('twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'section');
    add_settings_field('linkedin', 'Linkedin URL', 'setting_linkedin', 'theme-options', 'section');

	register_setting('section', 'facebook');
	register_setting('section', 'instagram');
	register_setting('section', 'twitter');
    register_setting('section', 'linkedin');
}
add_action('admin_init', 'social_media_settings_page_setup');

// Facebook input
function setting_facebook() { ?>
	<input type="text" name="facebook" value="<?php echo get_option('facebook'); ?>" />
<?php }

// Instagram input
function setting_instagram() { ?>
	<input type="text" name="instagram" value="<?php echo get_option('instagram'); ?>" />
<?php }

// Twitter input
function setting_twitter() { ?>
	<input type="text" name="twitter" value="<?php echo get_option('twitter'); ?>" />
<?php }

// Linkedin input
function setting_linkedin() { ?>
	<input type="text" name="linkedin" value="<?php echo get_option('linkedin'); ?>" />
<?php }

function social_media_settings_page() { ?>
	<div class="social_media_section">
		<h1>Social media URLs</h1>
		<form method="post" action="options.php">
			<?php 
				settings_fields('section'); 
				do_settings_sections('theme-options'); 
				submit_button(); 
			?>
		</form>
	</div>
<?php }


function social_media_styling() { ?>
	<style type="text/css">
		.social_media_section {
			margin: 3em;
			text-align: center;
		}
		.social_media_section form {
			margin: 1em auto;
			width: max-content;
		}
	</style>
<?php }
add_action('admin_head', 'social_media_styling');