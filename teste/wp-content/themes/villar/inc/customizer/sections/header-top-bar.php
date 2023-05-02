<?php

if ( ! function_exists( 'villar_register_top_bar_options' ) ) {
	/**
	 * @param $wp_customize
	 * @param $section_id
	 * @param int $priority
	 */
	function villar_register_top_bar_options( $wp_customize, $section_id, $priority = 100 ) {

		$wp_customize->add_section( $section_id, [
			'title'    => esc_html__( 'Top Bar', 'villar' ),
			'panel'    => 'villar_header_panel',
			'priority' => $priority,
		] );

		/* Disable Top Bar */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_disable_top_bar',
			'label'          => esc_html__( 'Disable Top Bar', 'villar' ),
			'section'        => $section_id,
			'custom_control' => Villar_Switch_Customize_Control::class,
		] );

		/* Disable Social Menu */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_disable_top_bar_social_menu',
			'label'          => esc_html__( 'Disable Social Menu', 'villar' ),
			'section'        => $section_id,
			'custom_control' => Villar_Switch_Customize_Control::class,
		] );

		/* Disable Border */
		villar_register_settings( $wp_customize, [
			'name'           => 'villar_disable_top_bar_border',
			'label'          => esc_html__( 'Disable Border', 'villar' ),
			'section'        => $section_id,
			'custom_control' => Villar_Switch_Customize_Control::class,
		] );

		villar_register_settings( $wp_customize, array(
			'name'           => 'villar_go_to_menu_locations',
			'settings'       => array(),
			'section'        => $section_id,
			'custom_control' => Villar_Call_To_Action_Customize_Control::class,
			'control_args'   => array(
				'action_label'  => esc_html__( 'Edit Menus', 'villar' ),
				'action_type'   => 'customize',
				'action_target' => 'menu_locations',
			)
		) );
	}
}
