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
    //'hide_empty' => true,
    //'exclude' => array(38, 6031, 15)
);

$product_categories = get_categories($args); 

foreach ($product_categories as $category) : 
    // echo "<pre>"; 
    // var_dump($category->name, urldecode($category->slug), $category->term_id);
    // echo "</pre>";
endforeach;

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product-category";
    $giftProposalsHeader = "Gift ideas";
    $kaba = 6118;
else :
	$baseLinkUrl = "product-category";
    $giftProposalsHeader = "Προτάσεις δώρων";
    $kaba = 6118;
endif; ?>

<section id="gift-ideas">
    <h3 class="gift-ideas__header"><?= $giftProposalsHeader; ?></h3>
    <div class="gift-ideas__wrapper">
        <a class="individual-gift lazyload blur-up" style="background-image: url( );" href="<?= $baseLinkUrl . '/καβα';?>">
            <div class="gift-ideas__name"><?php if (get_locale() == "en_GB") : echo "Cellar"; else : echo "Kάβα"; endif; ?></div>
        </a>
        <a class="individual-gift lazyload blur-up" style="background-image: url( );" href="<?= $baseLinkUrl . '/καβα';?>">
            <div class="gift-ideas__name"><?php if (get_locale() == "en_GB") : echo "Gift card"; else : echo "Κάρτα δώρου"; endif; ?></div>
        </a>
        <a class="individual-gift lazyload blur-up" style="background-image: url( );" href="<?= $baseLinkUrl . '/καβα';?>">
            <div class="gift-ideas__name"><?php if (get_locale() == "en_GB") : echo "Gifts"; else : echo "Μπαχαρικά κάθε μήνα για ένα χρόνο"; endif; ?></div>
        </a>
        <a class="individual-gift lazyload blur-up" style="background-image: url( );" href="<?= $baseLinkUrl . '/καβα';?>">
            <div class="gift-ideas__name"><?php if (get_locale() == "en_GB") : echo "Spices every month for a year"; else : echo "Προτάσεις δώρου"; endif; ?></div>
        </a>
    </div>
</section>