<?php
/**
 * Template part for displaying products slider in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$productType = $args['data']['product_type'];

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product";
    if ($productType == "popular") :
        $categories_header = "Popular products";
        $categoryId = 6376;
    elseif ($productType === "new-products") :
        $categories_header = "New products";
        $categoryId = 6152;
    else : 
        $categories_header = "Offers";
        $categoryId = 6401; 
    endif;
else :
    $baseLinkUrl = "product";
    if ($productType === "popular") :
        $categories_header = "Δημοφιλή προϊόντα";
        $categoryId = 6029;
    elseif ($productType === "new-products") :
        $categories_header = "Νέα προϊόντα";
        $categoryId = 6126;
    else : 
        $categories_header = "Προσφορές";
        $categoryId = 6128;
    endif;
endif; 

$args = array(
    'taxonomy' => 'product_cat',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
    'include' => $categoryId
);

$product_categories = get_categories($args); 
$categoryName = $product_categories[0]->cat_name;
$args2 = array('category' => array($categoryName));
$products = wc_get_products($args2); ?>

<section id="featured-products">
    <h3 class="product__header"><?= $categories_header; ?></h3>
    <div class="product__wrapper">
        <?php 
            foreach ($products as $product) :
                $productId = $product->get_id();
                $productName = $product->get_title();
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($productId), 'single-post-thumbnail')[0];
                $productLink =  $baseLinkUrl . "/" . urldecode($product->get_slug()); ?>

                <a class="individual-product lazyload blur-up" style="background-image: url('<?= $image; ?>');" href="<?= $productLink; ?>">
                    <div class="product__name"><?= $productName; ?></div>
                </a>
            <?php endforeach;
        ?>
    </div>
</section>