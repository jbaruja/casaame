<?php

if ( !function_exists( 'villar_register_footer_options' ) ) {
    /**
     * @param $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_footer_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, [
            'title'    => esc_html__( 'Footer Settings', 'villar' ),
            'priority' => $priority,
        ] );
        if ( villar_fs()->is_not_paying() ) {
            villar_register_settings( $wp_customize, array(
                'name'           => 'villar_footer_upsell_tips',
                'section'        => $section_id,
                'settings'       => array(),
                'custom_control' => Villar_Info_Customize_Control::class,
                'control_args'   => array(
                'messages' => array( esc_html__( 'Do you want to remove theme credits in the footer?', 'villar' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', villar_upsell_url(), __( 'Meet our Villar Pro', 'villar' ) ) ),
            ),
            ) );
        }
        /* Copyright */
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_copyright_text',
            'label'   => esc_html__( 'Copyright Text', 'villar' ),
            'section' => $section_id,
            'type'    => 'text',
        ] );
        /* Disable To Top */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_to_top',
            'label'          => esc_html__( 'Disable To Top Button', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
    }

}