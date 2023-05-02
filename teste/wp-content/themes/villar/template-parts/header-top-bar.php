<?php
/**
 * Template part for top bar in header.
 *
 * @package Villar
 */

$wrap_class = 'w-full py-8 bg-light dark:bg-dark';
if ( get_villar_setting( 'villar_disable_top_bar_border' ) !== true ) {
	$wrap_class .= ' border-b border-light-border dark:border-dark-border';
}
?>

<div class="<?php echo esc_attr( $wrap_class ); ?>">
    <div class="container px-half-gutter mx-auto lg:flex items-center">
		<?php

		/**
		 * Hook - villar_action_top_bar
		 *
		 * @hooked villar_add_top_menu              - 10
		 * @hooked villar_add_top_social_menu       - 20
		 */
		do_action( 'villar_action_top_bar' );
		?>
    </div>
</div>