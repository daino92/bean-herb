<?php

// Add Translations section to admin appearance customize screen
function bean_translations($wp_customize) {
	$wp_customize->add_section('bean_translations', array(
		'title' => 'Translations'
	));

	$wp_customize->add_setting('Shop info', array(
		'default' => 'Shop info'
	));

	$wp_customize->add_control(new WP_Customize_control($wp_customize, 'Shop info', array(
		'label' => 'Shop info',
		'section' => 'bean_translations',
		'settings' => 'Shop info'
	)));

	$wp_customize->add_setting('Working Times info', array(
		'default' => 'Working Times info'
	));

	$wp_customize->add_control(new WP_Customize_control($wp_customize, 'Working Times info', array(
		'type' => 'textarea',
		'label' => 'Working Times info',
		'section' => 'bean_translations',
		'settings' => 'Working Times info'
	)));
}
add_action('customize_register', 'bean_translations');

function front_page_banners($wp_customize) {

	// Front page banners
	$wp_customize->add_section("front_page_banners", array(
		"title" => "Front page banners"
	));

	for ($i = 1; $i <= 3; $i++) :
		$wp_customize->add_setting("Banner ${i} URL", array(
			"default" => ""
		));

		$wp_customize->add_control(new WP_Customize_control($wp_customize, "Banner ${i} URL", array(
			"label" => "Banner ${i} URL",
			"section" => "front_page_banners",
			"settings" => "Banner ${i} URL"
		)));

		$wp_customize->add_setting("Banner ${i} URL EN", array(
			"default" => ""
		));

		$wp_customize->add_control(new WP_Customize_control($wp_customize, "Banner ${i} URL EN", array(
			"label" => "Banner ${i} URL EN",
			"section" => "front_page_banners",
			"settings" => "Banner ${i} URL EN"
		)));

		$wp_customize->add_setting("Banner ${i}", array(
			"default"			=> "",
			"sanitize_callback"	=> "esc_url_raw",
		));
	
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "Banner ${i}", array(
			"label" 		=> __("Background img of Banner ${i}", "front_page_banners"),
			"section" 		=> "front_page_banners",
			"settings"	 	=> "Banner ${i}",
			"description" 	=> __("Select the background image to be used for Banner ${i}", "Bean_&_Herb")
		)));
	endfor;
}
add_action('customize_register', 'front_page_banners');