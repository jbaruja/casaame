<?php

if ( !function_exists( 'villar_asset_resolve' ) ) {
    /**
     * @param string
     *
     * @return string
     */
    function villar_asset_resolve( $path )
    {
        return get_template_directory_uri() . '/build/' . $path;
    }

}
if ( !function_exists( 'villar_get_premium_stylesheet_suffix' ) ) {
    /**
     * Get stylesheet file suffix
     *
     * @return string
     */
    function villar_get_premium_stylesheet_suffix()
    {
        $is_debug = defined( 'VILLAR_DEBUG' ) && VILLAR_DEBUG;
        if ( $is_debug ) {
            return '';
        }
        $suffix = '.min';
        return $suffix;
    }

}
if ( !function_exists( 'villar_get_stylesheet_suffix' ) ) {
    /**
     * Get stylesheet file suffix
     *
     * @return string
     */
    function villar_get_stylesheet_suffix()
    {
        return ( defined( 'VILLAR_DEBUG' ) && VILLAR_DEBUG ? '' : '.min' );
    }

}
if ( !function_exists( 'villar_get_script_suffix' ) ) {
    /**
     * Get script file suffix
     *
     * @return string
     */
    function villar_get_script_suffix()
    {
        return ( defined( 'VILLAR_DEBUG' ) && VILLAR_DEBUG ? '' : '.min' );
    }

}