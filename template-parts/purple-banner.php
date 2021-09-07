<?php
/**
 * Template part for displaying the purple banner in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */


$base_dir = get_template_directory_uri(); ?>

<div class="purple-bg">
    <div class="purple-bg__content">
        <div class="purple-bg__content--left">
            <div class="lazyload blur-up" style="background: url('<?= $base_dir; ?>/resources/images/homepage/papas.png')"></div>
        </div>
        <div class="purple-bg__content--right">
            <div class="lazyload blur-up" style="background: url('<?= $base_dir; ?>/resources/images/logo.png')"></div>
            <div class="content-message">
                <?php if (get_locale() == "en_GB") : ?>
                    We carefully choose our products <br> from certified producers from <br> Greece and the whole world
                <?php else : ?>
                    Eπιλέγουμε τα καλύτερα <br> προϊόντα από εγκεκριμένους <br> παραγωγούς απ΄ όλο τον κόσμο
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>