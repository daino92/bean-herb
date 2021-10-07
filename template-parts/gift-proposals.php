<?php
/**
 * Template part for displaying product categories slider in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$base_dir = get_template_directory_uri(); 
 
if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product-category";
    $giftProposalsHeader = "Gift ideas";
    $giftProposalsURL = "/accessories-gifts";
    $kava = 7008;
    $gift_card = 8491;
else :
	$baseLinkUrl = "product-category";
    $giftProposalsHeader = "Προτάσεις δώρων";
    $giftProposalsURL = "/αξεσουαρ-ειδη-δωρου";
    $kava = 6857;
    $gift_card = 8489;
endif;

$args = array(
    'taxonomy' => 'product_cat',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true,
    'include' => array($gift_card, $kava)
);

$product_categories = get_categories($args); ?>

<section id="gift-ideas">
    <h3 class="gift-ideas__header"><?= $giftProposalsHeader; ?></h3>
    <div class="gift-ideas__wrapper">
        <?php 
            foreach ($product_categories as $category) : 
                $catName = $category->cat_name;
                $id = $category->term_id;
                $catLink =  $baseLinkUrl . "/" . urldecode($category->slug);
                $thumbnailId = get_term_meta($id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnailId); ?>
                <a class="individual-gift lazyload blur-up lazy" 
                    style="background-image: url(<?= $image; ?>);" 
                    href="<?= $catLink; ?>" 
                    alt="<?= urldecode($category->slug); ?>" 
                    title="<?= urldecode($category->slug); ?>"
                >
                    <div class="gift-ideas__name"><?= $catName; ?></div>
                </a>
            <?php endforeach;
        ?>
        <a class="individual-gift lazyload blur-up" style="background-image: url(<?= $base_dir . '/dist/images/homepage/herbs.jpg' ?>);" href="">
            <div class="gift-ideas__name">
                <?php if (get_locale() == "en_GB") : echo "Gifts"; else : echo "Μπαχαρικά κάθε μήνα για ένα χρόνο"; endif; ?>
            </div>
        </a>
        <a class="individual-gift lazyload blur-up" style="background-image: url(<?= $base_dir . '/dist/images/homepage/gift-proposal.jpg' ?>);" href="<?= $baseLinkUrl . $giftProposalsURL ?>">
            <div class="gift-ideas__name">
                <?php if (get_locale() == "en_GB") : echo "Spices every month for a year"; else : echo "Προτάσεις δώρου"; endif; ?>
            </div>
        </a>
    </div>
</section>