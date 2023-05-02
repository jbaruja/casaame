<?php

/**
 * Options
 */
require get_parent_theme_file_path( 'inc/universal/options.php' );

if ( ! function_exists( 'villar_change_customizer_object' ) ) {
	/**
	 * Change a customizer object.
	 *
	 * @param $wp_customize
	 * @param $type
	 * @param $id
	 * @param $property
	 * @param $value
	 *
	 * @since 1.0.6
	 */
	function villar_change_customizer_object( $wp_customize, $type, $id, $property, $value ) {
		$accepted_types = array( 'setting', 'control', 'section', 'panel' );
		if ( ! in_array( $type, $accepted_types, true ) ) {
			return;
		}
		$object = call_user_func_array( array( $wp_customize, 'get_' . $type ), array( $id ) );

		if ( empty( $object ) ) {
			return;
		}

		$object->$property = $value;
	}
}

if ( ! function_exists( 'villar_register_settings' ) ) {
	/**
	 * Function to register control and setting.
	 *
	 * @param $wp_customize
	 * @param $arg
	 *
	 * @since 1.0.6
	 */
	function villar_register_settings( $wp_customize, $arg ) {

		// Initialize Settings
		$settings = array();
		if ( isset( $arg['setting'] ) ) {
			$arg['settings'] = array( $arg['setting'] );
			if ( is_array( $arg['setting'] ) && isset( $arg['setting']['id'] ) ) {
				$settings = $arg['setting']['id'];
			} else {
				$settings = $arg['name'];
			}
		}

		if ( ! isset( $arg['settings'] ) ) {
			$arg['settings'] = array( $arg['name'] );
			$settings        = $arg['name'];
		}

		foreach ( $arg['settings'] as $key => $options ) {
			$options = is_array( $options ) ? $options : get_villar_setting_args( $options );
			$id      = isset( $options['id'] ) ? $options['id'] : $arg['name'];

			if ( is_array( $settings ) ) {
				$settings[ $key ] = $id;
			}

			$wp_customize->add_setting( $id, array(
				'type'               => 'theme_mod',
				'sanitize_callback'  => $options['sanitize_callback'],
				'default'            => isset( $options['default'] ) ? $options['default'] : '',
				'transport'          => isset( $options['transport'] ) ? $options['transport'] : 'refresh',
				'theme_supports'     => isset( $options['theme_supports'] ) ? $options['theme_supports'] : '',
				'description_hidden' => isset( $options['description_hidden'] ) ? $options['description_hidden'] : 0,
			) );
		}

		// Initialize control args.
		$control = array(
			'label'    => isset( $arg['label'] ) ? $arg['label'] : '',
			'section'  => $arg['section'],
			'settings' => $settings,
		);

		if ( isset( $arg['control_args'] ) ) {
			$control = array_merge( $control, $arg['control_args'] );
		}

		if ( isset( $arg['active_callback'] ) ) {
			$control['active_callback'] = $arg['active_callback'];
		}

		if ( isset( $arg['priority'] ) ) {
			$control['priority'] = $arg['priority'];
		}

		if ( isset( $arg['choices'] ) ) {
			$control['choices'] = $arg['choices'];
		}

		if ( isset( $arg['type'] ) ) {
			$control['type'] = $arg['type'];
		}

		if ( isset( $arg['input_attrs'] ) ) {
			$control['input_attrs'] = $arg['input_attrs'];
		}

		if ( isset( $arg['description'] ) ) {
			$control['description'] = $arg['description'];
		}

		// Add control
		if ( isset( $arg['custom_control'] ) ) {
			$wp_customize->add_control( new $arg['custom_control']( $wp_customize, $arg['name'], $control ) );
		} else {
			$wp_customize->add_control( $arg['name'], $control );
		}
	}
}

if ( ! function_exists( 'villar_upsell_url' ) ) {
	function villar_upsell_url() {
		return network_admin_url( 'themes.php?page=villar-pricing' );
	}
}

if ( ! function_exists( 'villar_go_to_upsell' ) ) {
	/**
	 * Go to upsell
	 */
	function villar_go_to_upsell( $wp_customize, $section, $id, $label ) {
		if ( villar_fs()->is_not_paying() ) {
			villar_register_settings( $wp_customize, [
				'name'           => $id,
				'label'          => $label,
				'section'        => $section,
				'settings'       => [],
				'custom_control' => Villar_Call_To_Action_Customize_Control::class,
				'control_args'   => array(
					'action_label'  => $label,
					'action_type'   => 'url',
					'action_target' => villar_upsell_url(),
				)
			] );
		}
	}
}
