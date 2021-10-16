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
    $url = "terms-of-use/";
else :
	$newsletter__header = "εγγραφείτε στο NEWSLETTER μας!";
    $newsletter__btn__name = "ΕΓΓΡΑΦΗ";
    $accept__terms_part1 = "Έχω διαβάσει και συμφωνώ με τους";
    $accept__terms_part2 = "όρους χρήσης";
    $url = "όροι-χρήσης/";
endif; ?>

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
            <img class="lazyload"
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  
                data-src="<?= $base_dir ?>/dist/images/homepage/frame.png" 
                alt="woman-frame" 
                width="184" 
                height="242" />
            <div class="newsletter__signup">
                <div class="newsletter__header"><?= $newsletter__header ?></div>
                <div class="newsletter__input">
                    <input class="newsletter__email" type="email" name="email" placeholder="Email" required="">
                    <input class="newsletter__btn" type="submit" value="<?= $newsletter__btn__name ?>">
                    <span>
                        <input id="terms" type="checkbox" value="1" required="">
                        <label for="terms">
                            <?= $accept__terms_part1 ?> <a href="<?= $url ?>"><?= $accept__terms_part2 ?></a>
                        </label>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>