<?php

if ( !function_exists( 'villar_woo_setup' ) ) {
    /**
     * WooCommerce setup.
     */
    function villar_woo_setup()
    {
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

}
add_action( 'after_setup_theme', 'villar_woo_setup' );
if ( !function_exists( 'villar_woo_before_content' ) ) {
    /**
     * Wrap woocommerce content - start
     */
    function villar_woo_before_content()
    {
        $layout_class = ( get_villar_store_layout() === 'left-sidebar' ? 'lg:flex-row-reverse' : 'lg:flex-row' );
        echo  '<div class="container mx-auto lg:flex ' . $layout_class . '">' ;
        echo  '<div class="content w-full lg:w-0 lg:flex-grow lg:flex-shrink-0 px-half-gutter">' ;
    }

}
add_action( 'woocommerce_before_main_content', 'villar_woo_before_content', 5 );
if ( !function_exists( 'villar_woo_after_content' ) ) {
    /**
     * Wrap woocommerce content - start
     */
    function villar_woo_after_content()
    {
        echo  '</div>' ;
        /**
         * Hook - villar_action_sidebar.
         *
         * @hooked villar_add_primary_sidebar   - 10;
         */
        do_action( 'villar_action_sidebar', get_villar_store_layout() );
        echo  '</div>' ;
    }

}
add_action( 'woocommerce_after_main_content', 'villar_woo_after_content', 50 );
// Remove Default Sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
if ( !function_exists( 'villar_remove_woo_breadcrumbs' ) ) {
    /**
     * Remove breadcrumbs for WooCommerce page.
     */
    function villar_remove_woo_breadcrumbs()
    {
        remove_action(
            'woocommerce_before_main_content',
            'woocommerce_breadcrumb',
            20,
            0
        );
    }

}
add_action( 'init', 'villar_remove_woo_breadcrumbs' );
/**
 * Change the order of the on sale button.
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
// Support for dark mode
add_filter( 'villar_filter_app_class', 'wc_body_class' );