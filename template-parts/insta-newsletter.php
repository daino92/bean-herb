<?php
/**
 * Template part for displaying instagram feed and newsletter in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$base_dir = get_template_directory_uri(); 

if (get_locale() == "en_GB") : 
	$newsletter__header = "sign up to our NEWSLETTER!";
    $newsletter__btn__name = "SIGN UP";
    $accept__terms_part1 = "I have read and accepted the terms of conditions";
    $accept__terms_part2 = "the terms of conditions";
else :
	$newsletter__header = "εγγραφείτε στο NEWSLETTER μας!";
    $newsletter__btn__name = "ΕΓΓΡΑΦΗ";
    $accept__terms_part1 = "Έχω διαβάσει και συμφωνώ με τους";
    $accept__terms_part2 = "όρους χρήσης";
endif; 

?>

<section id="instagram">
    <div class="instagram__banner">
        <div class="instagram__header">INSTA FEED</div>
        <div class="instagram__content">
            <?php echo do_shortcode('[insta-gallery id="1"]'); ?>
        </div>
    </div>
</section>
<section id="newsletter">
    <div class="newsletter__banner">
        <div class="newsletter__content">
            <img src="<?= $base_dir; ?>/resources/images/homepage/frame.png" />
            <div class="newsletter__signup">
                <div class="newsletter__header"><?= $newsletter__header; ?></div>
                <div class="newsletter__input">
                    <input class="newsletter__email" type="email" name="email" placeholder="Email" required="">
                    <input class="newsletter__btn" type="submit" value="<?= $newsletter__btn__name; ?>">
                    <span>
                        <input name="terms" type="checkbox" value="1" required="">
                        <?= $accept__terms_part1; ?> <a href="https://beanandherb.com/%cf%8c%cf%81%ce%bf%ce%b9-%cf%87%cf%81%ce%ae%cf%83%ce%b7%cf%82/"><?= $accept__terms_part2; ?></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>