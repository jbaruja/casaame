<?php

if ( !function_exists( 'villar_register_banner_options' ) ) {
    /**
     * @param $wp_customize
     * @param $section_id
     * @param int $priority
     */
    function villar_register_banner_options( $wp_customize, $section_id, $priority = 100 )
    {
        $wp_customize->add_section( $section_id, [
            'title'    => esc_html__( 'Banner Settings', 'villar' ),
            'panel'    => 'villar_header_panel',
            'priority' => $priority,
        ] );
        if ( villar_fs()->is_not_paying() ) {
            villar_register_settings( $wp_customize, array(
                'name'           => 'villar_banner_upsell_tips',
                'section'        => $section_id,
                'settings'       => array(),
                'custom_control' => Villar_Info_Customize_Control::class,
                'control_args'   => array(
                'messages' => array( esc_html__( 'In our Pro version, we provide widgets area in Banner.', 'villar' ), esc_html__( 'We also provide 9 additional widgets for you to create awesome websites.', 'villar' ), sprintf(
                '<a href="%1$s" target="_blank">%2$s</a> or <a href="%3$s" target="_blank">%4$s</a>',
                villar_upsell_url(),
                __( 'Get Villar Pro', 'villar' ),
                'https://villar.ibllex.com/',
                __( 'View Demo Site', 'villar' )
            ) ),
            ),
            ) );
        }
        /* Disable Header Banner */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_header_banner',
            'label'          => esc_html__( 'Disable Header Banner', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable Header Image */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_header_image',
            'label'          => esc_html__( 'Disable Header Image', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable Site Title */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_site_title',
            'label'          => esc_html__( 'Disable Site Title', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable Tagline */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_tagline',
            'label'          => esc_html__( 'Disable Tagline', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        /* Disable Search */
        villar_register_settings( $wp_customize, [
            'name'           => 'villar_disable_banner_search',
            'label'          => esc_html__( 'Disable Search', 'villar' ),
            'section'        => $section_id,
            'custom_control' => Villar_Switch_Customize_Control::class,
        ] );
        // Header Text Alignment
        villar_register_settings( $wp_customize, [
            'name'    => 'villar_header_text_alignment',
            'choices' => villar_get_text_alignment_options(),
            'label'   => esc_html__( 'Text Alignment', 'villar' ),
            'section' => $section_id,
            'type'    => 'select',
        ] );
    }

}
/**
 * Register Customizer partials.
 *
 * @param $wp_customize
 */
function villar_header_banner_customizer_partials( $wp_customize )
{
    // Bail if selective refresh is not available.
    
    if ( !isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->get_setting( 'blogname' )->transport = 'refresh';
        $wp_customize->get_setting( 'blogdescription' )->transport = 'refresh';
        return;
    }
    
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    // Register partial for blogname.
    $wp_customize->selective_refresh->add_partial( 'blogname', array(
        'selector'            => '.site-title a',
        'container_inclusive' => false,
        'render_callback'     => 'villar_customize_partial_blogname',
    ) );
    // Register partial for blogdescription.
    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
        'selector'            => '.site-description',
        'container_inclusive' => false,
        'render_callback'     => 'villar_customize_partial_blogdescription',
    ) );
}

add_action( 'customize_register', 'villar_header_banner_customizer_partials', 99 );
if ( !function_exists( 'villar_customize_partial_blogname' ) ) {
    /**
     * Render the site title for the selective refresh partial.
     *
     */
    function villar_customize_partial_blogname()
    {
        bloginfo( 'name' );
    }

}
if ( !function_exists( 'villar_customize_partial_blogdescription' ) ) {
    /**
     * Render the site title for the selective refresh partial.
     */
    function villar_customize_partial_blogdescription()
    {
        bloginfo( 'description' );
    }

}