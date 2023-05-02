<?php

if ( !function_exists( 'get_villar_default_colors' ) ) {
    function get_villar_default_colors()
    {
        static  $options = null ;
        if ( !$options ) {
            $options = array(
                'primary_color'  => [
                'default' => '#e2833d',
                'label'   => esc_html__( 'Primary Color', 'villar' ),
            ],
                'primary_darken' => [
                'default' => '#cd691f',
                'label'   => esc_html__( 'Primary Darken', 'villar' ),
            ],
                'gradient_start' => [
                'default' => '#fcdc96',
                'label'   => esc_html__( 'Gradient Start', 'villar' ),
            ],
                'gradient_end'   => [
                'default' => '#f7bd9e',
                'label'   => esc_html__( 'Gradient End', 'villar' ),
            ],
            );
        }
        return $options;
    }

}
if ( !function_exists( 'villar_register_color_options' ) ) {
    /**
     * @param \WP_Customize_Manager $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_color_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, array(
            'title'    => esc_html__( 'Colors', 'villar' ),
            'panel'    => 'villar_global_panel',
            'priority' => $priority,
        ) );
        // Register out color settings
        foreach ( get_villar_default_colors() as $id => $arg ) {
            villar_register_settings( $wp_customize, array(
                'name'           => 'villar_' . $id,
                'label'          => $arg['label'],
                'setting'        => array(
                'default'           => $arg['default'],
                'sanitize_callback' => 'sanitize_hex_color',
            ),
                'section'        => $section_id,
                'custom_control' => \WP_Customize_Color_Control::class,
            ) );
        }
        villar_go_to_upsell(
            $wp_customize,
            $section_id,
            'villar_colors_go_to_upsell',
            esc_html__( 'Want More Color Options? See Villar Pro', 'villar' )
        );
    }

}
if ( !function_exists( 'get_villar_color' ) ) {
    /**
     * Get Copyright text.
     *
     * @param string $color_name
     *
     * @return string
     */
    function get_villar_color( $color_name )
    {
        $defaults = get_villar_default_colors();
        
        if ( isset( $defaults[$color_name] ) ) {
            $color = get_theme_mod( 'villar_' . $color_name, $defaults[$color_name]['default'] );
        } else {
            $color = get_theme_mod( 'villar_' . $color_name );
        }
        
        return apply_filters( 'villar_filter_palette_' . $color_name, $color );
    }

}