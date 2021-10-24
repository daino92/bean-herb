<?php

// Custom Polylang String translations
add_action('init', function() {
	if (function_exists('pll_register_string')) {

		// Footer translations
		pll_register_string('Products', 'Products', 'Footer Section', false);
		pll_register_string('Menu', 'Menu', 'Footer Section', false);
		pll_register_string('Support', 'Support', 'Footer Section', false);
		pll_register_string('Contact', 'Contact', 'Footer Section', false);
		pll_register_string('Follow Us', 'Follow Us', 'Footer Section', false);
		pll_register_string('Shop', 'Shop', 'Footer Section', false);
		pll_register_string('Working Times', 'Working Times', 'Footer Section', false);

		pll_register_string('Shop info', get_theme_mod('Shop info'), 'Footer Section', false);
		pll_register_string('Working Times info', get_theme_mod('Working Times info'), 'Footer Section', false);

		// General information
		pll_register_string('Shop email', get_theme_mod('Shop email'), 'General Information', false);

		// Eshop featuring
		for ($i = 1; $i <= 3; $i++) :
			pll_register_string("Eshop featuring ${i} text", get_theme_mod("Eshop featuring ${i} text"), 'Eshop featuring', false);
		endfor;
	}
});