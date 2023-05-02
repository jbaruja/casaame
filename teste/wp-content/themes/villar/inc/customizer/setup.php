<?php

/**
 * Theme Customizer
 */

// Theme Settings
require get_parent_theme_file_path( 'inc/customizer/settings.php' );

/**
 * Global Settings
 */
require get_parent_theme_file_path( 'inc/customizer/sections/global-sidebar.php' );
require get_parent_theme_file_path( 'inc/customizer/sections/global-container.php' );
require get_parent_theme_file_path( 'inc/customizer/sections/global-typography.php' );
require get_parent_theme_file_path( 'inc/customizer/sections/global-colors.php' );

/**
 * Archive Settings
 */
require get_parent_theme_file_path( 'inc/customizer/sections/archive.php' );

/**
 * Single Post Settings
 */
require get_parent_theme_file_path( 'inc/customizer/sections/single-post.php' );

/**
 * Header Settings
 */
require get_parent_theme_file_path( 'inc/customizer/sections/header-top-bar.php' );
require get_parent_theme_file_path( 'inc/customizer/sections/header-banner.php' );
require get_parent_theme_file_path( 'inc/customizer/sections/header-navbar.php' );

/**
 * Footer Settings
 */
require get_parent_theme_file_path( 'inc/customizer/sections/footer.php' );

/**
 * Preloader Settings
 */
require get_parent_theme_file_path( 'inc/customizer/sections/preloader.php' );

if ( ! function_exists( 'villar_register_custom_controls_type' ) ) {
	/**
	 * Register custom controls
	 *
	 * @param $wp_customize
	 */
	function villar_register_custom_controls_type( $wp_customize ) {
		if ( method_exists( $wp_customize, 'register_control_type' ) ) {

			/**
			 * Controls
			 */
			require get_parent_theme_file_path( 'inc/customizer/controls/class-customize-control.php' );
			require get_parent_theme_file_path( 'inc/customizer/controls/class-call-to-action-control.php' );
			require get_parent_theme_file_path( 'inc/customizer/controls/class-info-control.php' );
			require get_parent_theme_file_path( 'inc/customizer/controls/class-image-radio-control.php' );
			require get_parent_theme_file_path( 'inc/customizer/controls/class-switch-control.php' );
			require get_parent_theme_file_path( 'inc/customizer/controls/class-sortable-control.php' );

			$wp_customize->register_control_type( 'Villar_Call_To_Action_Customize_Control' );
			$wp_customize->register_control_type( 'Villar_Info_Customize_Control' );
			$wp_customize->register_control_type( 'Villar_Image_Radio_Button_Customize_Control' );
			$wp_customize->register_control_type( 'Villar_Switch_Customize_Control' );
			$wp_customize->register_control_type( 'Villar_Sortable_Customize_Control' );
		}
	}
}
add_action( 'customize_register', 'villar_register_custom_controls_type' );

if ( ! function_exists( 'villar_customize_register' ) ) {
	/**
	 * Villar Customize Register
	 *
	 * @param WP_Customize_Manager $wp_customize theme Customizer object
	 */
	function villar_customize_register( $wp_customize ) {
		// Load customizer helper functions
		require get_parent_theme_file_path( 'inc/customizer/helpers.php' );
		require get_parent_theme_file_path( 'inc/customizer/sanitize-functions.php' );

		// Register panels
		$wp_customize->add_panel( 'villar_global_panel', array(
			'title'    => esc_html__( 'Global Settings', 'villar' ),
			'priority' => 25,
		) );

		$wp_customize->add_panel( 'villar_header_panel', array(
			'title'    => esc_html__( 'Header Settings', 'villar' ),
			'priority' => 25,
		) );

		/**
		 * Change default customize objects
		 */
		villar_change_customizer_object( $wp_customize, 'section', 'header_image', 'panel', 'villar_header_panel' );
		villar_change_customizer_object( $wp_customize, 'section', 'header_image', 'title', esc_html( 'Banner Image', 'villar' ) );
		villar_change_customizer_object( $wp_customize, 'section', 'header_image', 'priority', 150 );

		/**
		 * Register custom sections and settings
		 */

		// Global panel
		villar_register_sidebar_options( $wp_customize, 'villar_sidebar_section' );
		villar_register_container_options( $wp_customize, 'villar_container_section' );
		villar_register_typography_options( $wp_customize, 'villar_typography_section' );
		villar_register_color_options( $wp_customize, 'villar_colors_section' );

		// Archive
		villar_register_archive_options( $wp_customize, 'villar_archive_section', 25 );
		// Single Post
		villar_register_single_post_options( $wp_customize, 'villar_single_post_section', 25 );

		// Header
		villar_register_top_bar_options( $wp_customize, 'villar_top_bar_section' );
		villar_register_banner_options( $wp_customize, 'villar_banner_section' );
		villar_register_navbar_options( $wp_customize, 'villar_navbar_section', 200 );

		// Footer
		villar_register_footer_options( $wp_customize, 'villar_footer_section', 25 );
		// Preloader
		villar_register_preloader_options( $wp_customize, 'villar_preloader_section', 25 );
	}
}
add_action( 'customize_register', 'villar_customize_register' );

if ( ! function_exists( 'villar_customizer_scripts' ) ) {
	/**
	 * Enqueue our scripts and styles on customizer panel.
	 */
	function villar_customizer_scripts() {
		wp_enqueue_script(
			'villar-custom-controls-script',
			trailingslashit( get_template_directory_uri() ) . 'build/js/customizer-controls' . villar_get_script_suffix() . '.js',
			array(
				'jquery',
				'wp-color-picker',
				'customize-base',
			),
			VILLAR_VERSION,
			true
		);

		wp_enqueue_style(
			'villar-custom-controls-style',
			trailingslashit( get_template_directory_uri() ) . 'build/css/customizer-controls' . villar_get_stylesheet_suffix() . '.css',
			array( 'wp-color-picker' ),
			VILLAR_VERSION
		);
	}
}
add_action( 'customize_controls_enqueue_scripts', 'villar_customizer_scripts' );
