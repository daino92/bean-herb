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

?>
<!doctype html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Bean & Herb">
	<link rel="profile" href="https://gmpg.org/xfn/11">
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
			<?php
			if (function_exists('the_custom_logo')) the_custom_logo();
			if (is_front_page() && is_home()) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e('Primary Menu', 'bean-herb'); ?></button>
			<?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'container_class' => 'main-menu')); ?>
			<?php if (function_exists('bean_herb_woocommerce_header_cart')) bean_herb_woocommerce_header_cart(); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->