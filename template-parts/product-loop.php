<?php
/**
 * Template part for displaying products slider in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$productType = $args['data']['productType'];

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product";
    if ($productType == "popular") :
        $categories_header = "Popular products";
        $categoryId = 7115;
    elseif ($productType === "new") :
        $categories_header = "New products";
        $categoryId = 6891;
    else : 
        $categories_header = "Offers";
        $categoryId = 7140; 
    endif;
else :
    $baseLinkUrl = "product";
    if ($productType === "popular") :
        $categories_header = "Δημοφιλή προϊόντα";
        $categoryId = 6768;
    elseif ($productType === "new") :
        $categories_header = "Νέα προϊόντα";
        $categoryId = 6865;
    else : 
        $categories_header = "Προσφορές";
        $categoryId = 6867;
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

<section id="featured-products__<?= $productType; ?>">
    <h2 class="product__header"><?= $categories_header; ?></h2>
    <div class="product__wrapper">
        <?php 
            foreach ($products as $product) :
                $productId = $product->get_id();
                $productName = $product->get_title();
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($productId), 'single-post-thumbnail')[0];
                $productLink =  $baseLinkUrl . "/" . urldecode($product->get_slug()); ?>
                <div>
                    <a id="product-<?= $productId; ?>" class="individual-product lazyload blur-up lazy" 
                        style="background-image: url('<?= $image; ?>');" 
                        href="<?= $productLink; ?>"
                        alt="<?= urldecode($product->get_slug()); ?>" 
                        title="<?= urldecode($product->get_slug()); ?>"
                    >
                        <div class="product__name"><?= $productName; ?></div>
                    </a>
                </div>
            <?php endforeach;
        ?>
    </div>
</section>