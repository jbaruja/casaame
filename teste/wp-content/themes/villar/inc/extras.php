<?php

if ( !function_exists( 'wp_body_open' ) ) {
    // see: https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
    function wp_body_open()
    {
        do_action( 'wp_body_open' );
    }

}
if ( !function_exists( 'villar_add_scope_class' ) ) {
    /**
     * Add scope class.
     *
     * @param array $input
     *
     * @return array
     */
    function villar_add_scope_class( $input )
    {
        $input[] = 'villar';
        return $input;
    }

}
add_filter( 'villar_filter_html_class', 'villar_add_scope_class' );
if ( !function_exists( 'villar_custom_body_class' ) ) {
    /**
     * Custom body class.
     *
     * @param string|array $input
     *
     * @return array Array of classes.
     */
    function villar_custom_body_class( $input )
    {
        // Adds a class of group-blog to blogs with more than 1 published author.
        if ( is_multi_author() ) {
            $input[] = 'group-blog';
        }
        // Add default color mode
        
        if ( isset( $_COOKIE['villar-color-mode'] ) ) {
            $input[] = esc_attr( $_COOKIE['villar-color-mode'] );
        } else {
        }
        
        return $input;
    }

}
add_filter( 'body_class', 'villar_custom_body_class' );
add_filter( 'body_class', 'villar_add_scope_class' );
if ( !function_exists( 'villar_add_global_style' ) ) {
    function villar_add_global_style( $input )
    {
        // global style
        $input = array_merge( $input, array(
            'relative',
            'w-full',
            'h-full',
            'min-h-screen',
            'text-light-base',
            'dark:text-dark-base',
            'bg-light',
            'dark:bg-dark'
        ) );
        // Add global font family.
        $input[] = get_villar_default_font_family();
        return $input;
    }

}
add_filter( 'villar_filter_app_class', 'villar_add_global_style' );
if ( !function_exists( 'villar_add_header_margin' ) ) {
    /**
     * Add margin to header
     *
     * @param array $input
     *
     * @return array
     */
    function villar_add_header_margin( $input )
    {
        $input[] = 'mb-30 md:mb-40';
        return $input;
    }

}
add_filter( 'villar_filter_header_class', 'villar_add_header_margin' );
if ( !function_exists( 'villar_do_elementor_location' ) ) {
    /**
     * Do the Elementor location, if it does not exist, display the custom template part.
     *
     * @param string $elementor_location
     * @param string $template_part
     */
    function villar_do_elementor_location( $elementor_location, $template_part = '' )
    {
        if ( !function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( $elementor_location ) ) {
            get_template_part( $template_part );
        }
    }

}
if ( !function_exists( 'villar_opensans_font_url' ) ) {
    /**
     * Get opensans font url
     */
    function villar_opensans_font_url()
    {
        return add_query_arg( 'family', urlencode( 'Open Sans:400,400i,600,600i,700,700i' ), "//fonts.googleapis.com/css" );
    }

}
if ( !function_exists( 'villar_lato_font_url' ) ) {
    /**
     * Get lato font url
     */
    function villar_lato_font_url()
    {
        return add_query_arg( 'family', urlencode( 'Lato:400,400i,700,700i' ), "//fonts.googleapis.com/css" );
    }

}
if ( !function_exists( 'villar_abhaya_libre_font_url' ) ) {
    /**
     * Get abhaya libre font url
     */
    function villar_abhaya_libre_font_url()
    {
        return add_query_arg( 'family', urlencode( 'Abhaya Libre:400,500,700' ), "//fonts.googleapis.com/css" );
    }

}
if ( !function_exists( 'villar_playfair_font_url' ) ) {
    /**
     * Get playfair font url
     */
    function villar_playfair_font_url()
    {
        return add_query_arg( 'family', urlencode( 'Playfair Display:400,700' ), "//fonts.googleapis.com/css" );
    }

}
if ( !function_exists( 'villar_rokkitt_font_url' ) ) {
    /**
     * Get rokkitt font url
     */
    function villar_rokkitt_font_url()
    {
        return add_query_arg( 'family', urlencode( 'Rokkitt' ), "//fonts.googleapis.com/css" );
    }

}
if ( !function_exists( 'villar_kalam_font_url' ) ) {
    /**
     * Get kalam font url
     */
    function villar_kalam_font_url()
    {
        return add_query_arg( 'family', urlencode( 'Kalam' ), "//fonts.googleapis.com/css" );
    }

}