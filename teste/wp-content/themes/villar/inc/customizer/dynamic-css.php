<?php

if ( !function_exists( 'villar_dynamic_css' ) ) {
    /**
     * Create dynamic css for our theme.
     *
     * @return string
     */
    function villar_dynamic_css()
    {
        $css = '';
        $css .= '
			:root {
				--villar-color-primary: ' . get_villar_color( 'primary_color' ) . ';
				--villar-color-primary-darken: ' . get_villar_color( 'primary_darken' ) . ';
				--villar-color-gradient-start: ' . get_villar_color( 'gradient_start' ) . ';
				--villar-color-gradient-end: ' . get_villar_color( 'gradient_end' ) . ';
				--villar-color-black: #000000;
				--villar-color-white: #ffffff;
			}';
        /**
         * Header banner
         */
        if ( !get_villar_setting( 'villar_disable_header_image' ) ) {
            $css .= '
		.header-banner {
		    background-image:url(' . esc_url( get_header_image() ) . ');
		    background-position-y: center;
		    background-position-x: center;
		    background-size: cover;
		}';
        }
        return $css;
    }

}