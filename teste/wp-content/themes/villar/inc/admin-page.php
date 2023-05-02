<?php

// Add Villar Admin Page
if ( ! function_exists( 'villar_admin_page' ) ) {
	function villar_admin_page() {
		add_theme_page( esc_html__( 'Villar Theme', 'villar' ), esc_html__( 'Villar Theme', 'villar' ), 'edit_theme_options', 'villar', 'villar_admin_page_output' );
	}
}
add_action( 'admin_menu', 'villar_admin_page' );

if ( ! function_exists( 'villar_admin_page_output' ) ) {
	/**
	 * Admin welcome page
	 */
	function villar_admin_page_output() {
		get_template_part( 'template-parts/admin', 'welcome' );
	}
}

if ( ! function_exists( 'villar_admin_notices' ) ) {
	/**
	 * Show admin notices
	 */
	function villar_admin_notices() {
		$screen = get_current_screen();
		if ( 'appearance_page_villar' !== $screen->id ) {
			get_template_part( 'template-parts/admin', 'notices' );
		}
	}
}
add_action( 'admin_notices', 'villar_admin_notices' );

if ( ! function_exists( 'villar_dismiss_notice' ) ) {
	/**
	 * Dismiss admin notice
	 */
	function villar_dismiss_notice() {
		global $current_user;

		$user_id = $current_user->ID;

		$dismiss_option = filter_input( INPUT_GET, 'villar_dismiss', FILTER_SANITIZE_STRING );
		if ( is_string( $dismiss_option ) ) {
			add_user_meta( $user_id, "villar_dismissed_$dismiss_option", 'true', true );
		}
	}
}
add_action( 'admin_init', 'villar_dismiss_notice' );