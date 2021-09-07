<?php
/**
 * Template part for displaying the orange banner in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$base_dir = get_template_directory_uri(); ?>

<div class="orange-bg">
    <div class="orange-bg__content">
        <div class="orange-bg__content--left">
            <div class="lazyload blur-up" style="background: url('<?= $base_dir; ?>/resources/images/homepage/fourface.png')"></div>
        </div>
        <div class="orange-bg__content--right">
            <div class="content-message">
                <?php if (get_locale() == "en_GB") : ?>
                    Discover our essential <br> oils & <br> cosmetics! <br><a href="../product-category/beauty-care/">DISCOVER THEM!</a>
                <?php else : ?>
                    αιθέρια έλαια <br> και είδη <br> περιποίησης <br><a href="product-category/ομορφια-περιποιηση/">ΑΝΑΚΑΛΥΨΤΕ ΤΑ!</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>