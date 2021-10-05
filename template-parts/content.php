<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$catID = get_the_category();
$categoryName = $catID[0]->name;
$categorySlug = $catID[0]->slug; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if (is_singular()) : the_title('<h1 class="entry-title">', '</h1>'); else : 
				the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); endif; 
		?>
	</header>
	<div class="single-post__wrapper">
		<div class="single-post__main">
			<?php bean_herb_post_thumbnail(); ?>

			<div class="entry-content">
				<?php
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'bean-herb'),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post(get_the_title())
						)
					); ?>

					<div class="entry-meta">
						<span class="category-link">
							<?php if (get_locale() == "en_GB") : echo "Category"; else : echo "Κατηγορία"; endif; ?>: 
							<a href=""><?= $categoryName; ?></a>
						</span>
						<?php bean_herb_posted_on(); bean_herb_posted_by(); ?>
						<a href="<?php the_permalink() ?>#respond">
							<?php if (get_locale() == "en_GB") : echo "Leave a comment"; else : echo "Άφησε ένα σχόλιο"; endif; ?>
						</a>
					</div>

					<?php wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__('Pages:', 'bean-herb'),
							'after'  => '</div>',
						)
					);

					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) : comments_template(); endif;
				?>
			</div>
		</div>
		<div class="single-post__recent">
			<h3><?php if (get_locale() == "en_GB") : echo "Recent articles"; else : echo "Πρόσφατα άρθρα"; endif; ?></h3>
			<ul>
				<?php 
					$query = new WP_Query(array (
						'posts_per_page' => 3
					)); 
					while ($query->have_posts()) : $query->the_post(); ?>
					<li>
						<a href="<?php the_permalink() ?>">
							<?php the_title(); ?>
						</a>
					</li>	
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</div>
	</div>

	<!-- <footer class="entry-footer"> -->
		<?php //bean_herb_entry_footer(); ?>
	<!-- </footer> -->
</article>