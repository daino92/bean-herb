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
                <div id="mc_embed_signup">
                    <form action="https://beanandherb.us7.list-manage.com/subscribe/post?u=051e9c98bf1d3b14a9b55865f&amp;id=684851bf1c" 
                            method="post" 
                            id="mc-embedded-subscribe-form" 
                            name="mc-embedded-subscribe-form" 
                            class="validate" 
                            target="_blank" 
                            novalidate>
                        <div id="mc_embed_signup_scroll">
                            <div class="newsletter__input">
                                <input class="newsletter__email" type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                                <div style="position: absolute; left: -5000px;" aria-hidden="true">
                                    <input type="text" name="b_051e9c98bf1d3b14a9b55865f_684851bf1c" tabindex="-1" value="">
                                </div>
                                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                                <div class="newsletter__btn"><?= $newsletter__btn__name ?></div>
                                <span>
                                    <input id="terms" type="checkbox" value="1" required="">
                                    <label for="terms">
                                        <?= $accept__terms_part1 ?> <a href="<?= $url ?>"><?= $accept__terms_part2 ?></a>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>