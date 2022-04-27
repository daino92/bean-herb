<?php /* Template Name: product categories template  */ ?>

<?php
/**
 * The template for displaying the product categories of this site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

get_header(); 

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../../product-category";
    $categories_header = "Product categories";
    $exclude = array(15);
else :
	$baseLinkUrl = "../product-category";
    $categories_header = "Κατηγορίες προϊόντων";
    $exclude = array(6770, 35);
endif;

$args = array(
    'taxonomy' => 'product_cat',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
    'exclude' => $exclude
);

$product_categories = get_categories($args); ?>

<div id="primary" class="content-area product-categories">
	<main id="main" class="site-main">
        <header class="woocommerce__general-bg-header">
	        <div class="centered">
				<h1 class="woocommerce__general-bg-header__title"><?= $categories_header; ?></h1>
			</div>
	    </header>
        <div class="masonry__container">
            <div class="columns">
                <?php 
                    foreach ($product_categories as $category) : 
                        $catName = $category->cat_name;
                        $id = $category->term_id;
                        $catLink =  $baseLinkUrl . "/" . urldecode($category->slug);
                        $thumbnailId = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnailId); ?>
                        <a id="product__cat-<?= $id; ?>" class="individual-category lazyload blur-up lazy" 
                            style="background-image: url(<?= $image; ?>);" 
                            href="<?= $catLink; ?>" 
                            alt="<?= urldecode($category->slug); ?>" 
                            title="<?= urldecode($category->slug); ?>"
                        >
                            <div class="category__name"><?= $catName; ?></div>
                        </a>
                    <?php endforeach; 
                ?>
            </div>
        </div>
	</main>
</div>

<?php get_footer();