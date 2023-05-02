<?php

if ( !function_exists( 'villar_register_single_post_options' ) ) {
    /**
     * @param $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_single_post_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, [
            'title'    => esc_html__( 'Single Post Settings', 'villar' ),
            'priority' => $priority,
        ] );
        /* Disable Featured Image */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_featured_image',
            'label'          => esc_html__( 'Disable Featured Image', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        // Header Text Alignment
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_post_header_text_alignment',
            'choices' => villar_get_text_alignment_options(),
            'label'   => esc_html__( 'Text Alignment', 'villar' ),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        if ( villar_fs()->is_not_paying() ) {
            villar_register_settings( $wp_customize, array(
                'name'           => 'villar_single_post_upsell_tips',
                'section'        => $section_id,
                'settings'       => array(),
                'custom_control' => Villar_Info_Customize_Control::class,
                'control_args'   => array(
                'messages' => array( esc_html__( 'Want more single post settings?', 'villar' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', villar_upsell_url(), __( 'Meet our Villar Pro', 'villar' ) ) ),
            ),
            ) );
        }
    }

}