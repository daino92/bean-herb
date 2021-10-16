<?php
/**
 * Template part for displaying the eshop featuring section in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$base_dir = get_template_directory_uri() ?>

<section class="featuring">
    <div class="featuring__wrapper">
        <div class="lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/mask-bg.png'?>)">
            <div class="featuring__inner-img lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/mask.png'?>)"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    We stay safe!
                <?php else : ?>
                    ΣΥΝΔΡΟΜΗ BEAN&HERB<br><br> Σύντομα κοντά σας!
                <?php endif; ?>
            </div>
        </div>
        <div class="lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/van-bg.png'?>)">
            <div class="featuring__inner-img lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/van.png'?>)"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    FREE SHIPPING FOR<br>ORDERS OVER 35€
                <?php else : ?>
                    προτάσεις <br>δώρων
                <?php endif; ?>
            </div>
        </div>
        <div class="lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/van-bg.png'?>)">
            <div class="featuring__inner-img lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/leaf.png'?>)"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    FRESHNESS GUARANTEE<br>for all our products
                <?php else : ?>
                    αξεσουάρ <br>τσαγιού & καφέ
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>