<?php
/**
 * Template part for displaying socials content in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

?>

<div class="top-bar">
    <div class="top-bar--section partners">
        <a href="https://beanandherb.com/sinergates/" class="">ΣΥΝΕΡΓΑΤΕΣ ΧΟΝΔΡΙΚΗΣ</a>
        <span>ΤΗΛ. ΠΑΡΑΓΓΕΛΙΕΣ: <a href="tel:2114175770">2114175770</a></span>
    </div>
    <div class="top-bar--section socials">
        <a title="Facebook" href="<?php echo get_option('facebook'); ?>" target="_blank" rel="noopener">
            <svg><use xlink:href="#facebook"></use></svg>
            <span class="screen-reader-text">Facebook page opens in new window</span>
        </a>
        <a title="Twitter" href="<?php echo get_option('twitter'); ?>" target="_blank" rel="noopener">
            <svg><use xlink:href="#twitter"></use></svg>
            <span class="screen-reader-text">Twitter page opens in new window</span>
        </a>
        <a title="Instagram" href="<?php echo get_option('instagram'); ?>" target="_blank" rel="noopener">
            <svg><use xlink:href="#instagram"></use></svg>
            <span class="screen-reader-text">Instagram page opens in new window</span>
        </a>
        <a title="LinkedIn" href="<?php echo get_option('linkedin'); ?>" target="_blank" rel="noopener">
            <svg><use xlink:href="#linkedin"></use></svg>
            <span class="screen-reader-text">Linkedin page opens in new window</span>
        </a>
    </div>
</div>