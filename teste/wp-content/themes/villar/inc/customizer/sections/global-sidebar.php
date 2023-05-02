<?php

if ( ! function_exists( 'villar_register_sidebar_options' ) ) {
	/**
	 * @param \WP_Customize_Manager $wp_customize
	 * @param $section_id
	 * @param int $priority
	 */
	function villar_register_sidebar_options( $wp_customize, $section_id, $priority = 100 ) {
		$wp_customize->add_section( $section_id, array(
			'title'    => esc_html__( 'Sidebar', 'villar' ),
			'panel'    => 'villar_global_panel',
			'priority' => $priority,
		) );

		/* Archive Layout */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_archive_layout',
			'label'          => esc_html__( 'Archive Layout', 'villar' ),
			'choices'        => villar_get_sidebar_layout_options(),
			'section'        => $section_id,
			'custom_control' => Villar_Image_Radio_Button_Customize_Control::class,
		] );

		/* Single Post Layout */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_single_layout',
			'label'          => esc_html__( 'Single Layout', 'villar' ),
			'choices'        => villar_get_sidebar_layout_options(),
			'section'        => $section_id,
			'custom_control' => Villar_Image_Radio_Button_Customize_Control::class,
		] );

		/* Page Layout */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_page_layout',
			'label'          => esc_html__( 'Page Layout', 'villar' ),
			'choices'        => villar_get_sidebar_layout_options(),
			'section'        => $section_id,
			'custom_control' => Villar_Image_Radio_Button_Customize_Control::class,
		] );

		if ( VILLAR_WOOCOMMERCE_ACTIVE ) {
			/* Store Layout */
			villar_register_settings( $wp_customize, [
				'name'           => 'villar_store_layout',
				'label'          => esc_html__( 'Store Layout', 'villar' ),
				'choices'        => villar_get_sidebar_layout_options(),
				'section'        => $section_id,
				'custom_control' => Villar_Image_Radio_Button_Customize_Control::class,
			] );
		}

		// Sidebar width
		villar_register_settings( $wp_customize, [
			'name'    => 'villar_sidebar_width',
			'label'   => esc_html__( 'Sidebar Width', 'villar' ),
			'choices' => villar_get_sidebar_width_options(),
			'section' => $section_id,
			'type'    => 'select',
		] );

		/* Sidebar Border Style */
		villar_register_settings( $wp_customize, [
			'name'    => 'villar_sidebar_border_style',
			'label'   => esc_html__( 'Sidebar Border Style', 'villar' ),
			'choices' => villar_get_border_style_options(),
			'section' => $section_id,
			'type'    => 'select',
		] );
	}
}

if ( ! function_exists( 'get_villar_override_layout' ) ) {
	/**
	 * Get override layout.
	 *
	 * @return string|null
	 */
	function get_villar_override_layout() {
		global $post;

		// Check if single template.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'villar_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				return $post_options['post_layout'];
			}
		}

		return null;
	}
}

if ( ! function_exists( 'get_villar_archive_layout' ) ) {
	/**
	 * Get archive layout option.
	 *
	 * @return string
	 */
	function get_villar_archive_layout() {

		$archive_layout = get_villar_setting( 'villar_archive_layout' );

		if ( $override = get_villar_override_layout() ) {
			$archive_layout = $override;
		}

		return $archive_layout;
	}
}

if ( ! function_exists( 'get_villar_single_layout' ) ) {
	/**
	 * Get single layout option.
	 *
	 * @return string
	 */
	function get_villar_single_layout() {

		$single_layout = get_villar_setting( 'villar_single_layout' );

		if ( $override = get_villar_override_layout() ) {
			$single_layout = $override;
		}

		return $single_layout;
	}
}

if ( ! function_exists( 'get_villar_page_layout' ) ) {
	/**
	 * Get page layout option.
	 *
	 * @return string
	 */
	function get_villar_page_layout() {

		$page_layout = get_villar_setting( 'villar_page_layout' );

		if ( $override = get_villar_override_layout() ) {
			$page_layout = $override;
		}

		return $page_layout;
	}
}

if ( ! function_exists( 'get_villar_store_layout' ) ) {
	/**
	 * Get store layout option.
	 *
	 * @return string
	 */
	function get_villar_store_layout() {

		$store_layout = get_villar_setting( 'villar_store_layout' );

		if ( $override = get_villar_override_layout() ) {
			$store_layout = $override;
		}

		return $store_layout;
	}
}
