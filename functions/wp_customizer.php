<?php

// Add Translations section to admin appearance customize screen
function bean_translations($wp_customize) {
	$wp_customize->add_section('bean_translations', array(
		'title' => 'General Information'
	));

	$wp_customize->add_setting('Shop info', array(
		'default' => 'Shop info'
	));

	$wp_customize->add_control(new WP_Customize_control($wp_customize, 'Shop info', array(
		'label' => 'Shop info',
		'section' => 'bean_translations',
		'settings' => 'Shop info'
	)));

	$wp_customize->add_setting('Shop phone', array(
		'default' => '+302114175770'
	));

	$wp_customize->add_control(new WP_Customize_control($wp_customize, 'Shop phone', array(
		'label' => 'Shop phone',
		'section' => 'bean_translations',
		'settings' => 'Shop phone'
	)));

	$wp_customize->add_setting('Shop email', array(
		'default' => 'info@beanandherb.com'
	));

	$wp_customize->add_control(new WP_Customize_control($wp_customize, 'Shop email', array(
		'label' => 'Shop email',
		'section' => 'bean_translations',
		'settings' => 'Shop email'
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

function featuring($wp_customize) {

	// Featuring section
	$wp_customize->add_section("featuring", array(
		"title" => "Featuring"
	));

	for ($i = 1; $i <= 3; $i++) :
		$wp_customize->add_setting("Feature ${i} URL", array(
			"default" => ""
		));

		$wp_customize->add_control(new WP_Customize_control($wp_customize, "Feature ${i} URL", array(
			"label" => "Feature ${i} URL",
			"section" => "featuring",
			"settings" => "Feature ${i} URL"
		)));

		$wp_customize->add_setting("Feature ${i} text", array(
			"default" => ""
		));
	
		$wp_customize->add_control(new WP_Customize_control($wp_customize, "Feature ${i} text", array(
			"type" => "textarea",
			"label" => "Feature ${i} text",
			"section" => "featuring",
			"settings" => "Feature ${i} text"
		)));

		$wp_customize->add_setting("Feature ${i} URL EN", array(
			"default" => ""
		));

		$wp_customize->add_control(new WP_Customize_control($wp_customize, "Feature ${i} URL EN", array(
			"label" => "Feature ${i} URL EN",
			"section" => "featuring",
			"settings" => "Feature ${i} URL EN"
		)));

		$wp_customize->add_setting("Feature ${i} text EN", array(
			"default" => ""
		));
	
		$wp_customize->add_control(new WP_Customize_control($wp_customize, "Feature ${i} text EN", array(
			"type" => "textarea",
			"label" => "Feature ${i} text EN",
			"section" => "featuring",
			"settings" => "Feature ${i} text EN"
		)));
	endfor;
}
add_action('customize_register', 'featuring');