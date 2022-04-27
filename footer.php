<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bean_&_Herb
 */

?>
		<footer id="colophon" class="site-footer">
			<div class="site-info col-full">
				<?php /* translators: 1: Theme name, 2: Theme author. */ //printf( esc_html__( 'Theme: %1$s by %2$s.', 'bean-herb' ), 'bean-herb', '<a href="http://underscores.me/">Daino</a>' ); ?>
				<div class="footer-container">
					<div class="sections">
						<div class="col">
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Products'))); ?>
								</div>
								<div class="section-content">
									<?php wp_nav_menu(array('theme_location' => 'menu-3', 'container_class' => 'footer-navigation')); ?>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Menu'))); ?>
								</div>
								<div class="section-content">
									<?php wp_nav_menu(array('theme_location' => 'menu-2', 'container_class' => 'footer-navigation')); ?>
								</div>
							</div>
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Support'))); ?>
								</div>
								<div class="section-content">
									<?php wp_nav_menu(array('theme_location' => 'menu-4', 'container_class' => 'footer-navigation')); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="sections">
						<div class="col">
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Contact'))); ?>
								</div>
								<div class="section-content">
									<a href="tel:<?php echo get_theme_mod("Shop phone"); ?>">
										T. <?php echo get_theme_mod("Shop phone"); ?>
									</a> <br>
									<a href="mailto:<?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Shop email"));} else { echo get_theme_mod("Shop email");} ?>">
										E-mail: <?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Shop email"));} else { echo get_theme_mod("Shop email");} ?>
									</a>
								</div>
							</div>
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Follow Us'))); ?>
								</div>
								<div class="section-content">
									<a href="<?php echo get_option('facebook'); ?>">Facebook</a><br>
									<a href="<?php echo get_option('instagram'); ?>">Instagram</a><br>
									<a href="<?php echo get_option('twitter'); ?>">Twitter</a><br>
									<a href="<?php echo get_option('linkedin'); ?>">LinkedIn</a>
								</div>
							</div>	
						</div>
						<div class="col">
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Shop'))); ?>
								</div>
								<div class="section-content">
									<?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Shop info"));} else { echo get_theme_mod("Shop info");} ?>
								</div>
							</div>
							<div class="sub-sections">
								<div class="section-title">
									<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Working Times'))); ?>
								</div>
								<div class="section-content">
									<?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Working Times info"));} else { echo get_theme_mod("Working Times info");} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<?php wp_footer(); ?>
	</body>
</html>