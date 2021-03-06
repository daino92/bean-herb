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

global $asset_version; 

if (get_locale() == "en_GB") : 
	$subMenu = "Shop";
else: 
	$subMenu = "Κατάστημα";
endif; ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Bean & Herb">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/fonts/Bean_Herb-Regular.ttf" as="font" type="font/ttf" crossorigin>
	<link rel="stylesheet" href='<?= get_stylesheet_directory_uri() . "/dist/styles/style.${asset_version}css?v=" . _S_VERSION ?>' />
	<?php wp_head(); ?>
	<script>
		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());

  		gtag('config', 'AW-10895649924');
		gtag('config', 'G-4RPWPGEBLY');

		window._tfa = window._tfa || [];
		window._tfa.push({notify: 'event', name: 'page_view', id: 1456793});
		!function (t, f, a, x) {
			if (!document.getElementById(x)) {
				t.async = 1;t.src = a;t.id=x;f.parentNode.insertBefore(t, f);
			}
		}(document.createElement('script'),
			document.getElementsByTagName('script')[0], 
			'//cdn.taboola.com/libtrc/unip/1456793/tfa.js', 
			'tb_tfa_script'
		);
	</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<div id="site-overlay">
		<div class="lds-ellipsis">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'bean-herb'); ?></a>
	<header id="masthead" class="site-header">
		<?php get_template_part('template-parts/content-socials', get_post_type()); ?>

		<div class="flexed">
			<a class="hamburger hamburger--spin" data-bs-toggle="collapse" href="#collapseMenu" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</a> 
			<div class="site-branding">
				<?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
				<h1 class="site-title"><a href="<?= esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
			</div>
			<nav class="secondary-menu">
				<div class="item" id="search">
					<a alt="#" title="Search bar" href="javascript:void(0);">
						<svg><use xlink:href="#search"></use></svg>
					</a>
				</div>
				<div class="item">
					<a alt="account" title="Account" href="<?= urldecode(wc_get_page_permalink('myaccount')); ?>">
						<svg><use xlink:href="#user"></use></svg>
					</a>
				</div>
				<?php if (function_exists('bean_herb_woocommerce_header_cart')) bean_herb_woocommerce_header_cart(); ?>
			</nav>
		</div>
		<?php get_template_part('template-parts/header-searchbar', get_post_type()); ?>

		<nav id="collapseMenu" class="main-navigation collapse">
			<?php 
				wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'primary-menu')); ?>

				<div id="shop-menu" class="accordion">
					<?php wp_nav_menu(
							array(
								'theme_location' => 'menu-1', 
								'submenu' => $subMenu,
								'menu_id' => 'shop-menu', 
								'menu_class' => 'accordion',
								'items_wrap' => '%3$s',
								'container' => ''
							)
						); 
					?>
				</div>
		</nav>
	</header>