<?php
/**
 * Template part for displaying the eshop featuring section in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

?>

<section class="eshop-featuring">
    <div class="eshop-featuring__wrapper">
        <div>
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    We stay safe!
                <?php else : ?>
                    ΣΥΝΔΡΟΜΗ BEAN&HERB<br><br> Σύντομα κοντά σας!
                <?php endif; ?>
            </div>
        </div>
        <div>
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : ?>
                    FREE SHIPPING FOR<br>ORDERS OVER 35€
                <?php else : ?>
                    προτάσεις <br>δώρων
                <?php endif; ?>
            </div>
        </div>
        <div>
            <div class="featuring__inner-img"></div>
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