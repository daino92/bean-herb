<?php
/**
 * Template part for displaying front-page banners in homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

 
$base_dir = get_template_directory_uri(); 

if (get_theme_mod("Banner 1"))          : $bgImageBanner1 = get_theme_mod("Banner 1"); endif;
if (get_theme_mod("Banner 1 URL"))      : $urlBanner1 = get_theme_mod("Banner 1 URL"); endif;
if (get_theme_mod("Banner 1 URL EN"))   : $urlBanner1EN = get_theme_mod("Banner 1 URL EN"); endif;
if (get_theme_mod("Banner 2"))          : $bgImageBanner2 = get_theme_mod("Banner 2"); endif;
if (get_theme_mod("Banner 2 URL"))      : $urlBanner2 = get_theme_mod("Banner 2 URL"); endif;
if (get_theme_mod("Banner 2 URL EN"))   : $urlBanner2EN = get_theme_mod("Banner 2 URL EN"); endif;
if (get_theme_mod("Banner 3"))          : $bgImageBanner3 = get_theme_mod("Banner 3"); endif;
if (get_theme_mod("Banner 3 URL"))      : $urlBanner3 = get_theme_mod("Banner 3 URL"); endif;
if (get_theme_mod("Banner 3 URL EN"))   : $urlBanner3EN = get_theme_mod("Banner 3 URL EN"); endif;

if (get_locale() == "en_GB") : 
	$baseLinkUrl = "../product-category";
    $endLinkURL1 = $urlBanner1EN;
    $endLinkURL2 = $urlBanner2EN;
    $endLinkURL3 = $urlBanner3EN;
else :
	$baseLinkUrl = "product-category";
    $endLinkURL1 = $urlBanner1;
    $endLinkURL2 = $urlBanner2;
    $endLinkURL3 = $urlBanner3;
endif; ?>

<section id="front-banners">
    <div class="banner-wrapper">
        <a class="first-column" href="/">
            <img class="lazyload" 
                alt="No sugar" 
                title="No sugar" 
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
                data-src="<?= $base_dir; ?>/resources/images/No-Sugar.png"/>
        </a>
        <div class="second-column">
            <a href="<?= $baseLinkUrl . "/" . $endLinkURL1; ?>" class="upper-banner">
                <img class="lazyload" 
                    alt="<?= $endLinkURL1; ?>" 
                    title="<?= $endLinkURL1; ?>" 
                    src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
                    data-src="<?= $bgImageBanner1; ?>" />
            </a>
            <div class="lower-banners">
                <a href="<?= $baseLinkUrl . "/" . $endLinkURL2; ?>">
                    <img class="lazyload" 
                        alt="<?= $endLinkURL2; ?>" 
                        title="<?= $endLinkURL2; ?>" 
                        src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
                        data-src="<?= $bgImageBanner2; ?>" />
                </a>
                <a href="<?= $baseLinkUrl . "/" . $endLinkURL3; ?>">
                    <img class="lazyload" 
                        alt="<?= $endLinkURL3; ?>" 
                        title="<?= $endLinkURL3; ?>" 
                        src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
                        data-src="<?= $bgImageBanner3; ?>" />
                </a>
            </div>
        </div>
    </div>
</section>