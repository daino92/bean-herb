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
endif; 

$args = array(
	'posts_per_page' => -1,
	'category_name' => array(
        'frontpage-banner-en',
        'frontpage-banner-el'
    ),
	'orderby' => 'date',
	'order' => 'DESC',
	'post_status' => 'publish'
);

$frontPageCarousels = get_posts($args); ?>

<section id="front-banners">
    <div class="banner-wrapper">
        <ul class="first-column">
            <?php foreach ($frontPageCarousels as $carousel) : setup_postdata($carousel); ?>
                <li id="carousel__<?= $carousel->ID; ?>">
                    <?php 
                        foreach(get_post_meta($carousel->ID) as $key => $val) :
                            foreach($val as $vals) :
                                if (preg_match('/url/', $key)) echo "<a href='$vals'>";
                            endforeach;
                        endforeach; 
                    
                        echo get_the_post_thumbnail($carousel->ID); ?>
                    </a>
                </li>   
            <?php endforeach; wp_reset_postdata(); ?>
        </ul>
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