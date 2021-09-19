<?php
/**
 * Template part for displaying product categories slider in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */


$args = array(
    'taxonomy' => 'product_cat',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
    'exclude' => array(6770, 15)
);

$product_categories = get_categories($args);

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product-category";
    $categories_header = "Product categories";
else :
	$baseLinkUrl = "product-category";
    $categories_header = "Κατηγορίες προϊόντων";
endif; ?>

<section id="product-categories">
    <h2 class="category__header"><?= $categories_header; ?></h2>
    <div class="category__wrapper">
        <?php 
            foreach ($product_categories as $category) : 
                $catName = $category->cat_name;
                $id = $category->term_id;
                $catLink =  $baseLinkUrl . "/" . urldecode($category->slug);
                $thumbnailId = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnailId); ?>
                <div>
                    <a id="product__cat-<?= $id; ?>" class="individual-category lazyload blur-up lazy" 
                        style="background-image: url(<?= $image; ?>);" 
                        href="<?= $catLink; ?>" 
                        alt="<?= urldecode($category->slug); ?>" 
                        title="<?= urldecode($category->slug); ?>"
                    >
                        <div class="category__name"><?= $catName; ?></div>
                    </a>
                </div>
            <?php endforeach; 
        ?>
    </div>
</section>