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