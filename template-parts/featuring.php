<?php
/**
 * Template part for displaying the featuring section in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

?>

<section class="featuring">
    <div class="featuring__wrapper">
        <a href="">
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    BEAN & HERB subscription<br><br>Coming soon
                <?php else : ?>
                    ΣΥΝΔΡΟΜΗ BEAN&HERB<br><br> Σύντομα κοντά σας!
                <?php endif; ?>
            </div>
        </a>
        <a href="">
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    GIFT<br>IDEAS
                <?php else : ?>
                    προτάσεις <br>δώρων
                <?php endif; ?>
            </div>
        </a>
        <a href="">
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    TEA &<br><br>COFFEE ACCESSORIES
                <?php else : ?>
                    αξεσουάρ <br>τσαγιού & καφέ
                <?php endif; ?>
            </div>
        </a>
    </div>
</section>