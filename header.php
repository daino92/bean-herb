<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bean_&_Herb
 */

if (get_locale() == "en_GB") :
	$accountTranslation = 'Account';   
else :
	$accountTranslation = 'Λογαριασμός';
endif; ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Bean & Herb">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/fonts/Bean_Herb-Regular.ttf" as="font" type="font/ttf" crossorigin> 
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<div class="lds-ellipsis">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'bean-herb'); ?></a>
	<?php get_template_part('template-parts/content-socials', get_post_type()); ?>
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
			<h1 class="site-title"><a href="<?= esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
		</div><!-- .site-branding -->
		<nav class="secondary-menu">
			<div class="account">
				<a href="<?= urldecode(wc_get_page_permalink('myaccount')); ?>">
					<svg>
						<use xlink:href="#user"></use>
					</svg>
					<?= $accountTranslation ?> 
				</a>
			</div>
			<?php if (function_exists('bean_herb_woocommerce_header_cart')) bean_herb_woocommerce_header_cart(); ?>
		</nav>
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e('Primary Menu', 'bean-herb'); ?></button>
			<?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'container_class' => 'main-menu')); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->