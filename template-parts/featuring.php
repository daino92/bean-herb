<?php
/**
 * Template part for displaying the featuring section in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

$base_dir = get_template_directory_uri(); 

if (get_theme_mod("Feature 1 URL"))      : $urlFeature1 = get_theme_mod("Feature 1 URL"); endif;
if (get_theme_mod("Feature 1 text"))     : $textFeature1 = get_theme_mod("Feature 1 text"); endif;
if (get_theme_mod("Feature 1 URL EN"))   : $urlFeature1EN = get_theme_mod("Feature 1 URL EN"); endif;
if (get_theme_mod("Feature 1 text EN"))  : $textFeature1EN = get_theme_mod("Feature 1 text EN"); endif;
if (get_theme_mod("Feature 2 URL"))      : $urlFeature2 = get_theme_mod("Feature 2 URL"); endif;
if (get_theme_mod("Feature 2 text"))     : $textFeature2 = get_theme_mod("Feature 2 text"); endif;
if (get_theme_mod("Feature 2 URL EN"))   : $urlFeature2EN = get_theme_mod("Feature 2 URL EN"); endif;
if (get_theme_mod("Feature 2 text EN"))  : $textFeature2EN = get_theme_mod("Feature 2 text EN"); endif;
if (get_theme_mod("Feature 3 URL"))      : $urlFeature3 = get_theme_mod("Feature 3 URL"); endif;
if (get_theme_mod("Feature 3 text"))     : $textFeature3 = get_theme_mod("Feature 3 text"); endif;
if (get_theme_mod("Feature 3 URL EN"))   : $urlFeature3EN = get_theme_mod("Feature 3 URL EN"); endif;
if (get_theme_mod("Feature 3 text EN"))  : $textFeature3EN = get_theme_mod("Feature 3 text EN"); endif;

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product-category";
    $endLinkURL1 = $urlFeature1EN;
    $endLinkURL2 = $urlFeature2EN;
    $endLinkURL3 = $urlFeature3EN;
else :
	$baseLinkUrl = "product-category";
    $endLinkURL1 = $urlFeature1;
    $endLinkURL2 = $urlFeature2;
    $endLinkURL3 = $urlFeature3;
endif; ?>

<section class="featuring">
    <div class="featuring__wrapper">
        <a href="<?= $baseLinkUrl . "/" . $endLinkURL1; ?>">
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : echo $textFeature1EN; else : echo $textFeature1; endif; ?>
            </div>
        </a>
        <a href="<?= $baseLinkUrl . "/" . $endLinkURL2; ?>">
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : echo $textFeature2EN; else : echo $textFeature2; endif; ?>
            </div>
        </a>
        <a href="<?= $baseLinkUrl . "/" . $endLinkURL3; ?>">
            <div class="featuring__inner-img"></div>
            <div class="featuring__inner-content">
                <?php if (get_locale() == "en_GB") : echo $textFeature3EN; else : echo $textFeature3; endif; ?>
            </div>
        </a>
    </div>
</section>