<?php /* Template Name: contact template */ ?>

<?php
/**
 * The template for displaying the Video listing page of this site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

get_header(); 

if (get_locale() == "en_GB") : 
    $pageHeader = "Contact";
    $contactHeader = "We will be happy to answer your questions!" . "<br>" . 
    "Just fill in the form below and we’ll be get back to you shortly!";
    $store = "Our Store";
    $street = "106 P. Tsaldari Str.,";
    $tk = "184 50, Nikaia, Athens, Greece";
    $phone = "+30 211 41 75 770";
    $email = "info@beanandherb.com";
    $workingHoursHeader = "Working hours";
    $workingHours = "MON. – WED. – SAT.: 8:00 AM – 4:00 PM" . "<br>" . 
    "TUE. – THU. – FRI.: 8:00 AM – 2:30 PM & 5:00 PM – 9:00 PM";
    $formNo = "1";
else :
    $pageHeader = "Επικοινωνία";
    $contactHeader = "Είμαστε στη διάθεσή σας για να απαντήσουμε σε κάθε σας ερώτηση!" . '<br>' . 
    "Συμπληρώστε την παρακάτω φόρμα και θα επικοινωνήσουμε μαζί σας!";
    $store = "Κατάστημα";
    $street = "Π. Τσαλδάρη 104-106";
    $tk = "184 50, Νίκαια, Αθήνα";
    $phone = "+30 211 41 75 770";
    $email = "info@beanandherb.gr";
    $workingHoursHeader = "Ωράριο λειτουργίας";
    $workingHours = "ΔΕΥ. – ΤΕΤ. – ΣΑΒ.: 8:00ΠΜ – 4:00ΜΜ" . "<br>" . 
    "ΤΡΙ. – ΠΕΜ. – ΠΑΡ.: 8:00ΠΜ – 9:00ΜΜ";
    $formNo = "2";
endif; ?>

<div id="primary" class="content-area">
	<main id="contact" class="site-main">
        <header class="woocommerce__general-bg-header">
	        <div class="centered">
				<h1 class="woocommerce__general-bg-header__title"><?= $pageHeader; ?></h1>
			</div>
	    </header>
        <div class="map-location">
            <iframe 
                width="100%" 
                height="360" 
                id="gmap_canvas" 
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12581.61311686892!2d23.6464063!3d37.9677169!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xdccb1314bf00fd0!2sBean%20%26%20Herb!5e0!3m2!1sen!2sgr!4v1605087855080!5m2!1sen!2sgr"
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0"
            ></iframe>
        </div>
        <div class="contact-details__wrapper">
            <div class="contact-details--info">
                <?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
                <h3 class="heading"><?= $store; ?></h3>
                <h3><?= $street; ?></h3>
                <h3><?= $tk; ?></h3>
                <h3>
                    <span class="heading">T. </span>
                    <a href="tel:<?= $phone; ?>"><?= $phone; ?></a>
                </h3>
                <h3>
                    <span class="heading">E-mail: </span>
                    <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
                </h3>
                <h3 class="heading"><?= $workingHoursHeader; ?></h3>
                <h3><?= $workingHours; ?></h3>
            </div>
            <div class="contact-details--contact-form">
                <h2><?= $contactHeader; ?></h2>
                <div class="form">
                    <?php echo do_shortcode("[contact-form-7 title='Contact form ${formNo}']"); ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php get_footer();