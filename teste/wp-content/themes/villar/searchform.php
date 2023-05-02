<?php
/**
 * Template for displaying search forms in Villar
 *
 * @package Villar
 */

$uniqid     = uniqid( 'search-form-' );
$aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';

// Backward compatibility, in case a child theme template uses a `label` argument.
if ( empty( $aria_label ) && ! empty( $args['label'] ) ) {
	$aria_label = 'aria-label="' . esc_attr( $args['label'] ) . '"';
}
?>
<form role="search" <?php echo esc_attr( $aria_label ); ?> method="get" class="search-form flex items-stretch"
      action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="flex items-stretch flex-grow mb-0" for="<?php echo esc_attr( $uniqid ); ?>">
        <span class="screen-reader-text"><?php _e( 'Search for:', 'villar' ); ?></span>
        <input type="search" id="<?php echo esc_attr( $uniqid ); ?>"
               class="search-input v-input-outline rounded-r-none border-r-0"
               placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'villar' ); ?>"
               value="<?php echo get_search_query(); ?>" name="s"/>
    </label>
    <button type="submit" class="search-submit v-button rounded-l-none px-16 py-8">
        <i class="fas fa-search"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Search', 'villar' ); ?></span>
    </button>
</form>
