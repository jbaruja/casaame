<?php

if ( !function_exists( 'get_villar_settings' ) ) {
    /**
     * All theme settings
     *
     * @return array|null
     */
    function get_villar_settings()
    {
        static  $settings = null ;
        if ( !$settings ) {
            $settings = [
                'villar_archive_layout'              => [
                'default'           => 'right-sidebar',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_single_layout'               => [
                'default'           => 'no-sidebar',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_page_layout'                 => [
                'default'           => 'no-sidebar',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_store_layout'                => [
                'default'           => 'no-sidebar',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_sidebar_width'               => [
                'default'           => 'lg:w-1/3',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_sidebar_border_style'        => [
                'default'           => 'border',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_single_width'                => [
                'default'           => 'content-slim',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_page_width'                  => [
                'default'           => 'content-slim',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_default_font_family'         => [
                'default'           => 'font-sans',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_site_title_text_uppercase'   => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_top_menu_text_uppercase'     => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_footer_menu_text_uppercase'  => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_navigation_text_uppercase'   => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_archive_style'               => [
                'default'           => 'list',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_entry_thumbnail_style'       => [
                'default'           => 'square',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_archive_image'               => [
                'default'           => 'medium',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_entry_border_style'          => [
                'default'           => 'border',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_archive_pagination'          => [
                'default'           => 'default',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_disable_featured_image'      => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_post_header_text_alignment'  => [
                'default'           => 'text-left',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_disable_top_bar'             => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_top_bar_social_menu' => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_top_bar_border'      => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_header_banner'       => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_header_image'        => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_site_title'          => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_tagline'             => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_banner_search'       => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_header_text_alignment'       => [
                'default'           => 'text-left',
                'sanitize_callback' => 'villar_sanitize_select',
            ],
                'villar_dark_mode_logo'              => [
                'default'           => '',
                'sanitize_callback' => 'absint',
            ],
                'villar_brand_text'                  => [
                'default'           => esc_html__( 'Brand', 'villar' ),
                'sanitize_callback' => 'sanitize_text_field',
            ],
                'villar_disable_site_brand'          => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_navbar_social_menu'  => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_color_mode_switcher' => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_search_button'       => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_navbar_top_border'   => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_copyright_text'              => [
                'default'           => esc_html__( 'Copyright &copy; All rights reserved.', 'villar' ),
                'sanitize_callback' => 'sanitize_text_field',
            ],
                'villar_disable_credits'             => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_to_top'              => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
                'villar_disable_preloader'           => [
                'default'           => false,
                'sanitize_callback' => 'villar_sanitize_checkbox',
            ],
            ];
        }
        return $settings;
    }

}
if ( !function_exists( 'get_villar_setting_args' ) ) {
    /**
     * Get setting args
     *
     * @param $id
     *
     * @return mixed
     */
    function get_villar_setting_args( $id )
    {
        $args = get_villar_settings()[$id];
        $args['id'] = $id;
        return $args;
    }

}
if ( !function_exists( 'get_villar_setting' ) ) {
    /**
     * Get theme setting value
     *
     * @param $id
     *
     * @return mixed|void
     */
    function get_villar_setting( $id )
    {
        $settings = get_villar_settings();
        
        if ( isset( $settings[$id] ) ) {
            $default = get_villar_settings()[$id]['default'];
            $value = get_theme_mod( $id, $default );
            return apply_filters( $id, $value );
        }
        
        return '';
    }

}