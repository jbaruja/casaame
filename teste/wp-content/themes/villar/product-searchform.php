<?php
/**
 * The template for displaying product search form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package Villar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="screen-reader-text"
           for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'villar' ); ?></label>
    <input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"
           class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'villar' ); ?>"
           value="<?php echo get_search_query(); ?>" name="s"/>
    <button type="submit" class="search-submit v-button rounded-l-none px-16 py-8">
        <i class="fas fa-search"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Product Search', 'villar' ); ?></span>
    </button>
    <input type="hidden" name="post_type" value="product"/>
</form>
