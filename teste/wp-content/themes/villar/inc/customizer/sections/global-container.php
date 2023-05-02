<?php

if ( ! function_exists( 'villar_register_container_options' ) ) {
	/**
	 * @param $wp_customize
	 * @param $section_id
	 * @param int $priority
	 */
	function villar_register_container_options( $wp_customize, $section_id, $priority = 100 ) {
		$wp_customize->add_section( $section_id, array(
			'title'    => esc_html__( 'Container', 'villar' ),
			'panel'    => 'villar_global_panel',
			'priority' => $priority,
		) );

		/* Single Container Width */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_single_width',
			'label'          => esc_html__( 'Single Post Container Style', 'villar' ),
			'choices'        => villar_get_container_width_options(),
			'section'        => $section_id,
			'custom_control' => Villar_Image_Radio_Button_Customize_Control::class,
		] );

		/* Page Container Width */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_page_width',
			'label'          => esc_html__( 'Page Container Style', 'villar' ),
			'choices'        => villar_get_container_width_options(),
			'section'        => $section_id,
			'custom_control' => Villar_Image_Radio_Button_Customize_Control::class,
		] );
	}
}

/**
 * Theme options getter with filter.
 */

if ( ! function_exists( 'get_villar_override_content_width' ) ) {
	/**
	 * Get override content width
	 *
	 * @return mixed|null
	 */
	function get_villar_override_content_width() {
		global $post;

		// Check if single template.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'villar_settings', true );
			if ( isset( $post_options['content_width'] ) && ! empty( $post_options['content_width'] ) ) {
				return $post_options['content_width'];
			}
		}

		return null;
	}
}

if ( ! function_exists( 'get_villar_single_width' ) ) {
	/**
	 * Get single style
	 *
	 * @return string
	 */
	function get_villar_single_width() {
		$single_width = get_villar_setting( 'villar_single_width' );

		if ( $override = get_villar_override_content_width() ) {
			$single_width = $override;
		}

		return $single_width;
	}
}

if ( ! function_exists( 'get_villar_page_width' ) ) {
	/**
	 * Get page style
	 *
	 * @return string
	 */
	function get_villar_page_width() {
		$page_width = get_villar_setting( 'villar_page_width' );

		if ( $override = get_villar_override_content_width() ) {
			$page_width = $override;
		}

		return $page_width;
	}
}
