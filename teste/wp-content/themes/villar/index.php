<?php
/**
 * The main template file.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Villar
 */

get_header();

if ( is_home() ) {
	villar_do_elementor_location( 'archive', 'template-parts/loop' );
} else if ( is_archive() ) {
	villar_do_elementor_location( 'archive', 'template-parts/archive' );
} else if ( is_search() ) {
	villar_do_elementor_location( 'archive', 'template-parts/search' );
} else if ( is_singular() ) {
	villar_do_elementor_location( 'single', 'template-parts/single' );
} else {
	villar_do_elementor_location( 'single', 'template-parts/content-none' );
}

get_footer();
