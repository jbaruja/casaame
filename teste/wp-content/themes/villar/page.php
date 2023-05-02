<?php
/**
 * The template for displaying all pages.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Villar
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	get_template_part( 'template-parts/page' );
}

get_footer();
