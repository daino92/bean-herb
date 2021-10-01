<?php /* Template Name: text template */ ?>

<?php
/**
 * The template for displaying the Video listing page of this site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

get_header(); ?>

<main class="full-width <?php echo get_post_meta($post->ID, 'background-color', true); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<?php if (is_singular()) : the_title('<h1 class="entry-title">', '</h1>');
			else : the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
			endif; ?>
		</header>

		<div class="form-content entry-content">
			<?php 
                the_content(sprintf(wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'Bean_&_Herb'),
				array('span' => array('class' => array(),),)), get_the_title() ));

			    wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'Bean_&_Herb'), 'after'  => '</div>',));
            ?>
		</div>
	</article>
</main>

<?php get_footer();