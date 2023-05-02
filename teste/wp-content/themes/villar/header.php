<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all the <head> section
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Villar
 */

// document open
get_template_part( 'template-parts/layout/document', 'open' );

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	/**
	 * Hook - villar_action_before.
	 *
	 * @hooked villar_add_preloader     - 10
	 */
	do_action( 'villar_action_before' );

	/**
	 * Hook - villar_action_before_header.
	 *
	 * @hooked villar_add_header_open       - 10
	 */
	do_action( 'villar_action_before_header' );

	/**
	 * Hook - villar_action_header.
	 *
	 * @hooked villar_add_header_top_bar        - 10
	 * @hooked villar_add_header_banner         - 20
	 * @hooked villar_add_primary_navbar        - 30
	 */
	do_action( 'villar_action_header' );

	/**
	 * Hook - villar_action_after_header.
	 *
	 * @hooked villar_add_header_close      - 10
	 */
	do_action( 'villar_action_after_header' );

	/**
	 * Hook - villar_action_before_content.
	 *
	 * @hooked villar_add_top_widget_area   - 10
	 */
	do_action( 'villar_action_before_content' );

	/**
	 * Hook - villar_action_content.
	 */
	do_action( 'villar_action_content' );
}
