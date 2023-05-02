<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the content and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Villar
 */

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	/**
	 * Hook - villar_action_after_content.
	 */
	do_action( 'villar_action_after_content' );

	/**
	 * Hook - villar_action_before_footer.
	 *
	 * @hooked villar_add_footer_widgets    - 10
	 * @hooked villar_footer_start          - 20
	 */
	do_action( 'villar_action_before_footer' );

	/**
	 * Hook - villar_action_footer.
	 *
	 * @hooked villar_footer_menu       - 10
	 * @hooked villar_footer_copyright  - 20
	 * @hooked villar_footer_credits    - 30
	 */
	do_action( 'villar_action_footer' );

	/**
	 * Hook - villar_action_after_footer.
	 *
	 * @hooked villar_add_to_top    - 10
	 */
	do_action( 'villar_action_after_footer' );

	/**
	 * Hook - villar_action_after.
	 */
	do_action( 'villar_action_after' );
}

// document close
get_template_part( 'template-parts/layout/document', 'close' );
