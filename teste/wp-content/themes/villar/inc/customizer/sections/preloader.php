<?php

if ( ! function_exists( 'villar_register_preloader_options' ) ) {
	/**
	 * @param $wp_customize
	 * @param $section_id
	 * @param int $priority
	 */
	function villar_register_preloader_options( $wp_customize, $section_id, $priority = 100 ) {
		$wp_customize->add_section( $section_id, [
			'title'    => esc_html__( 'Preloader Settings', 'villar' ),
			'priority' => $priority,
		] );

		/* Disable preloader */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_disable_preloader',
			'label'          => esc_html__( 'Disable Preloader', 'villar' ),
			'section'        => $section_id,
			'custom_control' => Villar_Switch_Customize_Control::class,
		] );
	}
}
