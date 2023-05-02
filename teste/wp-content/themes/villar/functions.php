<?php

define( 'VILLAR_VERSION', '1.0.10' );
// Used to check whether WooCommerce plugin is activated
define( 'VILLAR_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
// Used to check whether Elementor plugin is activated
define( 'VILLAR_ELEMENTOR_ACTIVE', defined( 'ELEMENTOR_VERSION' ) );

if ( !function_exists( 'villar_fs' ) ) {
    // Create a helper function for easy SDK access.
    function villar_fs()
    {
        global  $villar_fs ;
        
        if ( !isset( $villar_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $villar_fs = fs_dynamic_init( array(
                'id'              => '9782',
                'slug'            => 'villar',
                'type'            => 'theme',
                'public_key'      => 'pk_5f68310c86d24af136b63203705da',
                'is_premium'      => false,
                'premium_suffix'  => 'Pro',
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'navigation'      => 'tabs',
                'has_affiliation' => 'customers',
                'menu'            => array(
                'slug'   => 'villar',
                'parent' => array(
                'slug' => 'themes.php',
            ),
            ),
                'is_live'         => true,
            ) );
        }
        
        return $villar_fs;
    }
    
    // Init Freemius.
    villar_fs();
    // Signal that SDK was initiated.
    do_action( 'villar_fs_loaded' );
}

// content width
if ( !isset( $content_width ) ) {
    $content_width = 1140;
}
// Asset resolver
require get_template_directory() . '/inc/asset-resolver.php';
// Theme setup
require get_template_directory() . '/inc/villar-setup.php';
// Theme customizer
require get_template_directory() . '/inc/customizer/setup.php';
require get_template_directory() . '/inc/customizer/dynamic-css.php';
// Universal
require get_template_directory() . '/inc/universal/helpers.php';
// Filters
require get_template_directory() . '/inc/extras.php';
// Register metabox
require get_template_directory() . '/inc/metabox.php';
// Theme Hooks
require get_template_directory() . '/inc/theme-hooks.php';
// Tags
require get_template_directory() . '/inc/template-tags.php';
// Template functions
require get_template_directory() . '/inc/template-functions.php';
// Admin Page
require get_template_directory() . '/inc/admin-page.php';
// WooCommerce setup
if ( VILLAR_WOOCOMMERCE_ACTIVE ) {
    require get_template_directory() . '/inc/woocommerce-setup.php';
}
// Elementor setup
if ( VILLAR_ELEMENTOR_ACTIVE ) {
    require get_template_directory() . '/inc/elementor-setup.php';
}
// Runtime Lib
if ( file_exists( get_template_directory() . '/lib/bootstrap.php' ) ) {
    require get_template_directory() . '/lib/bootstrap.php';
}
/*
** TGM Plugin Activation Class
*/
require get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';
if ( !function_exists( 'get_villar_recommended_plugins' ) ) {
    /**
     * Recommended plugins for our theme.
     *
     * @return array[]
     */
    function get_villar_recommended_plugins()
    {
        $plugins = array(
            array(
            'name'     => 'Elementor',
            'slug'     => 'elementor',
            'required' => false,
        ),
            array(
            'name'     => 'Post Views Counter',
            'slug'     => 'post-views-counter',
            'required' => false,
        ),
            array(
            'name'     => 'Sidebar Manager',
            'slug'     => 'sidebar-manager',
            'required' => false,
        ),
            array(
            'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'required' => false,
        )
        );
        return $plugins;
    }

}
if ( !function_exists( 'villar_register_recommended_plugins' ) ) {
    function villar_register_recommended_plugins()
    {
        $config = array(
            'id'           => 'villar',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => '',
        );
        tgmpa( get_villar_recommended_plugins(), $config );
    }

}
add_action( 'tgmpa_register', 'villar_register_recommended_plugins' );