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
    'category' => get_cat_ID('blog'),
    //'post__not_in'   => array(get_the_ID()), // Exclude current post
    'no_found_rows'  => true, // We don't need pagination so this speeds up the query
    'orderby' => 'date',
	'order' => 'DESC',
	'post_status' => 'publish'
);

$blogPosts = get_posts($args);?>

<div id="primary" class="content-area">
    <header>
        <?php if (is_singular()) : the_title('<h1 class="entry-title">', '</h1>'); else : the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); endif; ?>
    </header>
    <main <?php post_class(); ?>>
        <?php 
            while (have_posts()) : the_post(); ?>
                <div class="posts__wrapper">
                    <?php foreach ($blogPosts as $post) : setup_postdata($post); 
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
                    <?php endforeach; wp_reset_postdata(); ?>  
                </div>
               <?php get_template_part('template-parts/single', get_post_type());
            endwhile; 
        ?>
    </main>
</div>

<?php get_footer();