<?php
/**
 * Template part for search form
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bean_&_Herb
 */

?>

<h2><?php _e('Search', 'bean-herb'); ?></h2>
<form method="get" id="search__form" role="search" action="<?php echo esc_url($args['data']['products_link']); ?>">
    <input type="hidden" name="search" value="search-products">
    <input type="text" name="search-input" value="" placeholder="<?php _e('Search a product', 'bean-herb'); ?>" required />
    <input type="submit" id="search-submit" value="Search" />
</form>