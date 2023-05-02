<?php

if ( !function_exists( 'villar_register_typography_options' ) ) {
    /**
     * @param $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_typography_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, array(
            'title'    => esc_html__( 'Typography', 'villar' ),
            'panel'    => 'villar_global_panel',
            'priority' => $priority,
        ) );
        villar_go_to_upsell(
            $wp_customize,
            $section_id,
            'villar_typography_go_to_upsell',
            esc_html__( 'Want More Typography Options? See Villar Pro', 'villar' )
        );
        /* Default Font Family */
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_default_font_family',
            'label'   => esc_html__( 'Default Font Family', 'villar' ),
            'choices' => villar_get_font_family_options(),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        /* Site Title Text Uppercase */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_site_title_text_uppercase',
            'label'          => esc_html__( 'Site Title Text Uppercase', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Top Menu Text Uppercase */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_top_menu_text_uppercase',
            'label'          => esc_html__( 'Top Menu Text Uppercase', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Footer Menu Text Uppercase */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_footer_menu_text_uppercase',
            'label'          => esc_html__( 'Footer Menu Text Uppercase', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Navigation Text Uppercase */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_navigation_text_uppercase',
            'label'          => esc_html__( 'Navigation Text Uppercase', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
    }

}
if ( !function_exists( 'get_villar_is_font_selected' ) ) {
    /**
     * Whether the font is used.
     *
     * @return bool
     */
    function get_villar_is_font_selected( $font )
    {
        return get_villar_default_font_family() === $font;
    }

}
if ( !function_exists( 'get_villar_default_font_family' ) ) {
    /**
     * Get default font family.
     */
    function get_villar_default_font_family()
    {
        return get_villar_setting( 'villar_default_font_family' );
    }

}