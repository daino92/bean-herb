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
					<div class="sections" style="flex: 1 0 20%;">
						<div class="section-title">
							<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Products'))); ?>
						</div>
						<div class="section-content">
							ΜΠΑΧΑΡΙΚΑ	<br>
							ΒΟΤΑΝΑ	<br>
							ΤΣΑΪ	<br>
							ΞΗΡΟΙ ΚΑΡΠΟΙ	<br>
							ΥΠΕΡΤΡΟΦΕΣ	<br>
							ΤΡΟΦΙΜΑ	<br>
							ΕΙΔΙΚΗ ΔΙΑΤΡΟΦΗ	<br>
							ΚΑΒΑ	<br>
							ΟΜΟΡΦΙΑ & ΠΕΡΙΠΟΙΗΣΗ	<br>
							ΕΛΑΙΑ & ΒΟΥΤΥΡΑ	<br>
							ΑΞΕΣΟΥΑΡ & ΕΙΔΗ ΔΩΡΟΥ	<br>
						</div>
					</div>
					<div class="sections head-section" style="flex: 1 0 70%;">
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
								<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Contact'))); ?>
							</div>
							<div class="section-content">
								<a href="tel:+30 2114175770">
									T. +30 211 41 75 770
								</a> <br>
								<a href="mailto:info@beanandherb.com">
									E-mail: info@beanandherb.com
								</a>
							</div>
						</div>
						<div class="sub-sections">
							<div class="section-title">
								<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Shop'))); ?>
							</div>
							<div class="section-content">
								Π. ΤΣΑΛΔΑΡΗ 104-106 184 50, ΝΙΚΑΙΑ ΑΘΗΝΑ	
							</div>
						</div>
						<div class="sub-sections">
							<div class="section-title">
								<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Support'))); ?>
							</div>
							<div class="section-content">
								ΤΡΟΠΟΙ ΠΛΗΡΩΜΗΣ<br>
								ΑΠΟΣΤΟΛΕΣ & ΕΠΙΣΤΡΟΦΕΣ<br>
								ΟΡΟΙ ΧΡΗΣΗΣ<br>
								COOKIES	
							</div>
						</div>
						<div class="sub-sections">
							<div class="section-title">
								<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Follow Us'))); ?>
							</div>
							<div class="section-content">
								FACEBOOK<br>
								INSTAGRAM<br>
								TWITTER<br>
								LINKED IN
							</div>
						</div>
						<div class="sub-sections">
							<div class="section-title">
								<?php if (function_exists('pll_e')) printf(esc_html__ (pll_e('Working Times'))); ?>
							</div>
							<div class="section-content">
								ΔΕΥ. - ΤΕΤ.:<br>
								8:00ΠΜ - 19:00ΜΜ<br>
								ΤΡΙ. - ΠΕΜ. - ΠΑΡ.:<br>
								8:00ΠΜ - 14:30ΜΜ - 17:00ΜΜ - 21:00ΜΜ<br>
								ΣΑΒ.:<br>
								08:00ΠΜ - 16:00ΜΜ
							</div>
						</div>
					</div>
				</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

	</body>
</html>