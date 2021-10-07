<?php
/**
 * Template part for displaying custom filters in archive-product.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */


if (get_locale() == "en_GB") : 
	$all_products = 'All products';
    $product_cat_title = "Product Categories";
    $uncategorized = 15;
    $gift_card = 8491;
    $exclude = array($uncategorized, $gift_card);
else :
    $all_products = 'Όλα τα προϊόντα';
    $product_cat_title = "Κατηγορίες προϊόντων";
    $no_category = 6770;
    $uncategorized = 35;
    $gift_card = 8489;
    $exclude = array($no_category, $uncategorized, $gift_card);
endif; 

$cat_args = array(
    'taxonomy'      => 'product_cat',
    'show_count'    => 1,
    'pad_counts'    => 1,
    'hierarchical'  => 1,
    'hide_empty'    => 1,
    'exclude'       => $exclude
);
$all_categories = get_categories($cat_args); ?>

<div class="filters__area__sidebar--toggle">
    <svg class="filters__area__sidebar-svg">
        <use xlink:href="#filter"></use>
    </svg>
</div>
<h2 class="product__categories--title"><?= $product_cat_title; ?></h2>
<ul id="filter" class="product__categories">
    <li class="cat-item">
        <a class="cats" data-slug="" href="<?= urldecode(wc_get_page_permalink('shop')); ?>"><?= $all_products; ?></a>
    </li>
    <?php
        foreach ($all_categories as $cat) :
            if ($cat->category_parent == 0) :
                $categoryId = $cat->term_id;  

                $sub_cat_args = array(
                    'parent'       => $categoryId,
                    'child_of'     => 0,
                    'taxonomy'     => 'product_cat',
                    'show_count'   => 1,
                    'pad_counts'   => 1,
                    'hierarchical' => 1,
                    'hide_empty'   => 1
                );
                $sub_cats = get_categories($sub_cat_args);
                $hasSubs = count($sub_cats) > 0; ?>

                <li class="cat-item cart-item-<?= $cat->term_id; ?> <?php if ($hasSubs) echo "cat-parent"; ?>">
                    <a class="cats" data-product-count="<?= $cat->count ?>" data-slug="<?= urldecode($cat->slug); ?>" data-category="<?php echo $cat->term_id; ?>" href="<?php echo urldecode(get_term_link($cat->slug, 'product_cat')) ?>">
                        <?php echo $cat->name; echo apply_filters('woocommerce_subcategory_count_html', ' <span class="cat-count">' . $cat->count . '</span>', $categoryId); ?> 
                    </a>
                    
                    <?php if ($sub_cats) : ?>
                        <div class="cats-toggle">
                            <svg class="down-svg">
                                <use xlink:href="#arrow-down"></use>
                            </svg>
                            <svg class="up-svg">
                                <use xlink:href="#arrow-up"></use>
                            </svg>
                        </div>
                        <ul class="children" style="display: none;">
                            <?php foreach($sub_cats as $sub_category) : ?>
                                <li class="cat-item cart-item-<?= $sub_category->term_id; ?>">
                                    <a class="cats" data-product-count="<?= $sub_category->count ?>" data-slug="<?= urldecode($sub_category->slug); ?>" data-category="<?php echo $sub_category->term_id; ?>" href="<?php echo urldecode(get_term_link($sub_category->slug, 'product_cat')) ?>">
                                        <?php echo $sub_category->name; echo apply_filters('woocommerce_subcategory_count_html', ' <span class="cat-count">' . $sub_category->count . '</span>', $categoryId); ?> 
                                    </a>
                                </li>
                            <?php endforeach;  ?>
                        </ul>
                    <?php endif; ?>
                </li>    
            <?php endif;      
        endforeach; 
    ?>
</ul>
<div class="product__search">
    <?php get_template_part(
        'template-parts/search-form', 
        null, 
        array('data' => array('products_link' => urldecode(wc_get_page_permalink('shop'))))
    ); ?>
</div>