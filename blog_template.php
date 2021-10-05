<?php /* Template Name: blog template */ ?>

<?php
/**
 * The template for displaying the Video listing page of this site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

get_header(); 

$args = array(
    'posts_per_page' => -1,
    'post__not_in'   => array(get_the_ID()), // Exclude current post
    'no_found_rows'  => true, // We don't need pagination so this speeds up the query
);

// Check for current post category and add tax_query to the query arguments
$cats = wp_get_post_terms(get_the_ID(), 'category'); 
$cats_ids = array();

foreach($cats as $wpex_related_cat) {
    $cats_ids[] = $wpex_related_cat->term_id; 
}

if (!empty($cats_ids)) {
    $args['category__in'] = $cats_ids;
}

$wpex_query = new wp_query($args); ?>

<div id="primary" class="content-area">
    <header>
        <?php if (is_singular()) : the_title('<h1 class="entry-title">', '</h1>');
			    else : the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif; 
            ?>
		</header>
    <main <?php post_class(); ?>>
        <?php 
            while (have_posts()) : the_post(); ?>
                <div class="posts__wrapper">
                    <?php foreach ($wpex_query->posts as $post) : 
                        $id = $post->ID;
                        $title = $post->post_title;
                        $image = get_the_post_thumbnail_url($id); ?>
                        <a class="posts" 
                            style="background-image: url(<?= $image; ?>);" 
                            href="<?php echo esc_url(urldecode(get_permalink($id))); ?>">
                            <div class="posts__name">
                                <?php esc_html_e($title); ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
               <?php get_template_part('template-parts/single', get_post_type());
            endwhile; 
        ?>
    </main>
</div>

<?php get_footer();