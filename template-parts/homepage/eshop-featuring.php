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
                <?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Eshop featuring 1 text"));} else { echo get_theme_mod("Eshop featuring 1 text");} ?>
            </div>
        </div>
        <div class="lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/van-bg.png'?>)">
            <div class="featuring__inner-img lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/van.png'?>)"></div>
            <div class="featuring__inner-content">
                <?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Eshop featuring 2 text"));} else { echo get_theme_mod("Eshop featuring 2 text");} ?>
            </div>
        </div>
        <div class="lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/van-bg.png'?>)">
            <div class="featuring__inner-img lazyload blur-up lazy" style="background-image: url(<?= $base_dir .'/dist/images/homepage/leaf.png'?>)"></div>
            <div class="featuring__inner-content">
                <?php if (function_exists('pll_e')){ echo pll_e(get_theme_mod("Eshop featuring 3 text"));} else { echo get_theme_mod("Eshop featuring 3 text");} ?>
            </div>
        </div>
    </div>
</section>