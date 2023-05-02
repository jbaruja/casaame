<?php

if ( !function_exists( 'villar_register_navbar_options' ) ) {
    /**
     * @param $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_navbar_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, [
            'title'    => esc_html__( 'Primary Navbar', 'villar' ),
            'panel'    => 'villar_header_panel',
            'priority' => $priority,
        ] );
        if ( villar_fs()->is_not_paying() ) {
            villar_register_settings( $wp_customize, array(
                'name'           => 'villar_navbar_upsell_tips',
                'section'        => $section_id,
                'settings'       => array(),
                'custom_control' => Villar_Info_Customize_Control::class,
                'control_args'   => array(
                'messages' => array( esc_html__( 'We provide some extra features in our pro version, such as sticky navbar, cart button, default color mode and more.', 'villar' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', villar_upsell_url(), __( 'Get Villar Pro', 'villar' ) ) ),
            ),
            ) );
        }
        /* Dark Logo */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_dark_mode_logo',
            'description'    => esc_html__( 'You can set a different logo for dark mode, if empty it will use the default logo.', 'villar' ),
            'label'          => esc_html__( 'Logo For Dark Mode', 'villar' ),
            'section'        => 'title_tagline',
            'priority'       => 9,
            'custom_control' => \WP_Customize_Cropped_Image_Control::class,
            'control_args'   => array(
            'width'       => 120,
            'height'      => 32,
            'flex-width'  => true,
            'flex-height' => true,
        ),
        ] );
        /* Brand Text */
        villar_register_settings( $wp_customize, [
            'name'        => 'villar_brand_text',
            'description' => esc_html__( 'If the custom logo is not set, this text will be displayed.', 'villar' ),
            'priority'    => 9,
            'label'       => esc_html__( 'Text Logo', 'villar' ),
            'section'     => 'title_tagline',
            'type'        => 'text',
        ] );
        /* Disable Site Brand */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_site_brand',
            'label'          => esc_html__( 'Disable Site Brand', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable Social Menu */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_navbar_social_menu',
            'label'          => esc_html__( 'Disable Social Menu', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable search button */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_search_button',
            'label'          => esc_html__( 'Disable Search Button', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable color mode switcher */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_color_mode_switcher',
            'label'          => esc_html__( 'Disable Color Mode Switcher', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable Top Border */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_navbar_top_border',
            'label'          => esc_html__( 'Disable Top Border', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        villar_register_settings( $wp_customize, array(
            'name'           => 'villar_go_to_site_identity',
            'settings'       => array(),
            'section'        => $section_id,
            'custom_control' => Villar_Call_To_Action_Customize_Control::class,
            'control_args'   => array(
            'action_label'  => esc_html__( 'Edit Logo', 'villar' ),
            'action_type'   => 'customize',
            'action_target' => 'title_tagline',
        ),
        ) );
    }

}