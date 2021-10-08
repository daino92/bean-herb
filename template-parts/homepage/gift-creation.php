<?php
/**
 * Template part for displaying the gift creation in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */


$base_dir = get_template_directory_uri() ?>

<div class="gift-creation-bg">
    <div class="gift-creation-bg__header">
        <?php if (get_locale() == "en_GB") : ?>
            Create your gift!
        <?php else : ?>
            Δημιουργήστε το δικό σας δώρο!
        <?php endif; ?>
    </div>
    <div class="gift-creation-bg__content">
        <div class="gift-creation-bg__content--inner">
            <div class="gift-num">1</div>
            <div class="gift-img lazyload blur-up" style="background: url('<?= $base_dir ?>/dist/images/homepage/gift-box.png')"></div>
            <div class="content-message">
                <?php if (get_locale() == "en_GB") : ?>
                    Select the gift package <br> you prefer and <br> cosmetics! <br>add to cart
                <?php else : ?>
                    Επιλέξτε τη<br>συσκευασία δώρου<br>που προτιμάτε<br>και προσθέστε την<br>στο καλάθι
                <?php endif; ?>
            </div>
        </div>
        <div class="gift-creation-bg__content--inner">
            <div class="gift-num">2</div>
            <div class="gift-img lazyload blur-up" style="background: url('<?= $base_dir ?>/dist/images/homepage/bottles.png')"></div>
            <div class="content-message">
                <?php if (get_locale() == "en_GB") : ?>
                    Add your gifts to the basket<br> <span style="color: #E35205;">after reading the gift<br>package details</span>
                <?php else : ?>
                    Προσθέστε τα προϊόντα που θέλετε<br>στο καλάθι<br><span style="color: #E35205;">αφού διαβάσετε τις σημειώσεις<br>της συσκευασίας δώρου<br>που επιλέξατε</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="gift-creation-bg__content--inner">
            <div class="gift-num">3</div>
            <div class="gift-img lazyload blur-up" style="background: url('<?= $base_dir ?>/dist/images/homepage/input.png')"></div>
            <div class="content-message">
                <?php if (get_locale() == "en_GB") : ?>
                    Add the recipient's<br>address and<br>place the order
                <?php else : ?>
                    Προσθέστε τη<br>διεύθυνση αποστολής<br>του δώρου<br>και ολοκληρώστε<br>την παραγγελία
                <?php endif; ?>  
            </div>
        </div>
    </div>
    <div class="gift-creation-bg__footer">
        <a href="<?php if (get_locale() == "en_GB") : echo home_url(); else : echo home_url(); endif; ?>">
            <?php if (get_locale() == "en_GB") : ?>
                Start now!
            <?php else : ?>
                Ξεκινήστε τώρα!
            <?php endif; ?>
        </a>
    </div>
</div>