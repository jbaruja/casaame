<?php

if ( !function_exists( 'villar_scripts_styles' ) ) {
    /**
     * Enqueue our scripts and styles.
     */
    function villar_scripts_styles()
    {
        // registers scripts and stylesheets
        wp_register_style(
            'villar-app',
            villar_asset_resolve( 'css/app' . villar_get_premium_stylesheet_suffix() . '.css' ),
            array(),
            VILLAR_VERSION
        );
        wp_register_script(
            'villar-app',
            villar_asset_resolve( 'js/app' . villar_get_script_suffix() . '.js' ),
            array(),
            VILLAR_VERSION,
            true
        );
        // enqueue global assets
        wp_enqueue_script( 'jquery' );
        wp_enqueue_style( 'villar-app' );
        wp_enqueue_script( 'villar-app' );
        // Comment reply link
        if ( is_singular() && comments_open() ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

}
add_action( 'wp_enqueue_scripts', 'villar_scripts_styles', 20 );
if ( !function_exists( 'villar_add_dynamic_css' ) ) {
    /**
     * Add dynamic css.
     */
    function villar_add_dynamic_css()
    {
        wp_register_style( 'villar-dynamic', false );
        wp_enqueue_style( 'villar-dynamic' );
        wp_add_inline_style( 'villar-dynamic', villar_dynamic_css() );
    }

}
add_action( 'wp_enqueue_scripts', 'villar_add_dynamic_css', 30 );
add_action( 'admin_enqueue_scripts', 'villar_add_dynamic_css' );
if ( !function_exists( 'villar_admin_styles' ) ) {
    /**
     * Enqueue styles for admin
     */
    function villar_admin_styles()
    {
        wp_register_style(
            'villar-admin-css',
            villar_asset_resolve( 'css/admin' . villar_get_stylesheet_suffix() . '.css' ),
            array(),
            VILLAR_VERSION
        );
        wp_enqueue_style( 'villar-admin-css' );
    }

}
add_action( 'admin_enqueue_scripts', 'villar_admin_styles' );
if ( !function_exists( 'villar_google_fonts_scripts' ) ) {
    /**
     * enqueue google fonts scripts.
     */
    function villar_google_fonts_scripts()
    {
        if ( get_villar_is_font_selected( 'font-google-opensans' ) ) {
            wp_enqueue_style( 'villar-opensans-font', villar_opensans_font_url() );
        }
        if ( get_villar_is_font_selected( 'font-google-lato' ) ) {
            wp_enqueue_style( 'villar-lato-font', villar_lato_font_url() );
        }
        if ( get_villar_is_font_selected( 'font-google-abhaya-libre' ) ) {
            wp_enqueue_style( 'villar-abhaya-libre-font', villar_abhaya_libre_font_url() );
        }
        if ( get_villar_is_font_selected( 'font-google-playfair' ) ) {
            wp_enqueue_style( 'villar-playfair-font', villar_playfair_font_url() );
        }
        if ( get_villar_is_font_selected( 'font-google-rokkitt' ) ) {
            wp_enqueue_style( 'villar-rokkitt-font', villar_rokkitt_font_url() );
        }
        if ( get_villar_is_font_selected( 'font-google-kalam' ) ) {
            wp_enqueue_style( 'villar-kalam-font', villar_kalam_font_url() );
        }
    }

}
add_action( 'wp_enqueue_scripts', 'villar_google_fonts_scripts' );
if ( !function_exists( 'villar_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function villar_setup()
    {
        // Make theme available for translation.
        load_theme_textdomain( 'villar', get_template_directory() . '/languages' );
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );
        // Add theme support for Custom Header.
        add_theme_support( 'custom-header', apply_filters( 'villar_filter_custom_header_args', array(
            'width'         => 1920,
            'height'        => 680,
            'flex-height'   => true,
            'default-image' => get_parent_theme_file_uri( '/build/images/villar_banner.jpg' ),
            'header-text'   => false,
        ) ) );
        register_default_headers( array(
            'default-image' => array(
            'url'           => '%s/build/images/villar_banner.jpg',
            'thumbnail_url' => '%s/build/images/villar_banner.jpg',
            'description'   => __( 'Default Header Image', 'villar' ),
        ),
        ) );
        // Enable support for custom logo.
        add_theme_support( 'custom-logo', array(
            'width'       => 120,
            'height'      => 32,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
        // Enable support for Post Thumbnails.
        add_theme_support( 'post-thumbnails' );
        // Gutenberg custom stylesheet
        add_theme_support( 'editor-styles' );
        add_editor_style( 'build/css/editor-style' . villar_get_stylesheet_suffix() . '.css' );
        // Support align wide
        add_theme_support( 'align-wide' );
        add_image_size( 'villar-feature', 480, 360 );
        add_image_size(
            'villar-carousel',
            1024,
            768,
            true
        );
        // Starter Content
        add_theme_support( 'starter-content', array(
            'options'   => array(
            'villar_header_text_alignment' => 'text-left',
        ),
            'nav_menus' => array(
            'social' => array(
            'name'  => __( 'Social Menu', 'villar' ),
            'items' => array(
            array(
            'title' => 'facebook',
            'url'   => 'https://facebook.com/',
        ),
            array(
            'title' => 'twitter',
            'url'   => 'https://twitter.com/',
        ),
            array(
            'title' => 'instagram',
            'url'   => 'https://instagram.com/',
        ),
            array(
            'title' => 'pinterest',
            'url'   => 'https://pinterest.com/',
        ),
            array(
            'title' => 'medium',
            'url'   => 'https://medium.com/',
        )
        ),
        ),
        ),
            'widgets'   => array(
            'sidebar-1' => array( 'search', 'archives', 'categories' ),
        ),
        ) );
        // Register nav menus.
        register_nav_menus( array(
            'primary'  => esc_html__( 'Primary Menu', 'villar' ),
            'top-menu' => esc_html__( 'Top Menu', 'villar' ),
            'footer'   => esc_html__( 'Footer Menu', 'villar' ),
            'social'   => esc_html__( 'Social Menu', 'villar' ),
        ) );
        // Add support for HTML5 markup.
        add_theme_support( 'html5', [
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'navigation-widgets'
        ] );
        // Enable support for selective refresh of widgets in Customizer.
        add_theme_support( 'customize-selective-refresh-widgets' );
    }

}
add_action( 'after_setup_theme', 'villar_setup' );
if ( !function_exists( 'villar_widgets_init' ) ) {
    /**
     * Register widgets area.
     *
     * @see https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    function villar_widgets_init()
    {
        $sidebar_class = 'widget clearfix rounded mb-gutter bg-light-and-dark p-half-gutter %2$s';
        $sidebar_class .= ' ' . villar_get_border_style( get_villar_setting( 'villar_sidebar_border_style' ) );
        $footer_class = 'widget clearfix p-half-gutter %2$s';
        $title_class = 'reset widget-title inline-block text-h4 uppercase font-serif text-light-and-dark mb-16';
        register_sidebar( array(
            'name'          => esc_html__( 'Primary Sidebar', 'villar' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'villar' ),
            'before_widget' => '<aside id="%1$s" class="' . $sidebar_class . '">',
            'after_widget'  => '</aside>',
            'before_title'  => '<div class="overflow-hidden text-center"><h2 class="' . $title_class . '">',
            'after_title'   => '</h2></div>',
        ) );
        register_sidebar( array(
            'name'          => esc_html__( 'After Posts Widget Area', 'villar' ),
            'id'            => 'sidebar-after-posts-widget-area',
            'description'   => esc_html__( 'Add widgets here to appear after post.', 'villar' ),
            'before_widget' => '<aside id="%1$s" class="widget clearfix mb-gutter %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<div class="overflow-hidden text-center"><h2 class="' . $title_class . '">',
            'after_title'   => '</h2></div>',
        ) );
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'villar' ), 1 ),
            'id'            => 'footer-1',
            'before_widget' => '<aside id="%1$s" class="' . $footer_class . '">',
            'after_widget'  => '</aside>',
            'before_title'  => '<div class="overflow-hidden text-center"><h3 class="' . $title_class . '">',
            'after_title'   => '</h3></div>',
        ) );
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'villar' ), 2 ),
            'id'            => 'footer-2',
            'before_widget' => '<aside id="%1$s" class="' . $footer_class . '">',
            'after_widget'  => '</aside>',
            'before_title'  => '<div class="overflow-hidden text-center"><h3 class="' . $title_class . '">',
            'after_title'   => '</h3></div>',
        ) );
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'villar' ), 3 ),
            'id'            => 'footer-3',
            'before_widget' => '<aside id="%1$s" class="' . $footer_class . '">',
            'after_widget'  => '</aside>',
            'before_title'  => '<div class="overflow-hidden text-center"><h3 class="' . $title_class . '">',
            'after_title'   => '</h3></div>',
        ) );
    }

}
add_action( 'widgets_init', 'villar_widgets_init' );