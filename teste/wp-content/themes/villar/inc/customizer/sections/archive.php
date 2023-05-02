<?php

if ( !function_exists( 'villar_register_archive_options' ) ) {
    /**
     * @param $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_archive_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, [
            'title'    => esc_html__( 'Archive Settings', 'villar' ),
            'priority' => $priority,
        ] );
        /* Archive Style */
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_archive_style',
            'choices' => villar_get_archive_style_options(),
            'label'   => esc_html__( 'Archive Style', 'villar' ),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        /* Archive Entry Thumbnail Style */
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_entry_thumbnail_style',
            'choices' => villar_get_thumbnail_style_options(),
            'label'   => esc_html__( 'Archive Entry Thumbnail Style', 'villar' ),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        // Archive Image
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_archive_image',
            'label'   => esc_html__( 'Archive Image Size', 'villar' ),
            'choices' => villar_get_image_sizes_options( false ),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        /* Archive Entry Border Style */
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_entry_border_style',
            'choices' => villar_get_border_style_options(),
            'label'   => esc_html__( 'Archive Entry Border Style', 'villar' ),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        // Archive Pagination
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_archive_pagination',
            'label'   => esc_html__( 'Pagination in Archive', 'villar' ),
            'choices' => villar_get_archive_pagination_options(),
            'section' => $section_id,
            'type'    => 'select',
        ] );
        if ( villar_fs()->is_not_paying() ) {
            villar_register_settings( $wp_customize, array(
                'name'           => 'villar_archive_upsell_tips',
                'section'        => $section_id,
                'settings'       => array(),
                'custom_control' => Villar_Info_Customize_Control::class,
                'control_args'   => array(
                'messages' => array( esc_html__( 'Want more archive settings?', 'villar' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', villar_upsell_url(), __( 'Meet our Villar Pro', 'villar' ) ) ),
            ),
            ) );
        }
    }

}