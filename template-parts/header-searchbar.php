<?php
/**
 * Template part for displaying search bar in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

?>

<div class="search-full-screen fill-space">
    <span class="close-search">
        <svg><use xlink:href="#close"></use></svg>
    </span>
    <form role="search" method="get" class="searchform" id="homepage-search" action="#" onsubmit="event.preventDefault();">
        <input type="text" class="search-query" id="myInputID"
            placeholder="Αναζήτηση προϊόντων" 
            value="" 
            name="s" 
            aria-label="Search" 
            title="Αναζήτηση προϊόντων" 
            autocomplete="off">
    </form>
    <div class="search-info-text">
        <span>Πληκτρολογήστε το προϊόν που αναζητάτε. </span>
    </div>
    <div class="search-results__wrapper">
        <div class="products__results">
            <div class="area__products">
                <div class="products the__products"></div>
            </div>
        </div>
    </div>
</div>