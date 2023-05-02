<?php

/**
 * Template part for navbar in header.
 *
 * @package Villar
 */
$attrs = '';
?>

<div <?php 
echo  esc_attr( $attrs ) ;
?>
        class="z-30 primary-navbar bg-light dark:bg-dark shadow-header-light dark:shadow-header-dark relative">
	<?php 
if ( get_villar_setting( 'villar_disable_navbar_top_border' ) !== true ) {
    ?>
        <div class="absolute z-30 left-0 top-0 w-full h-0.5 bg-gradient-to-r from-gradient-start to-gradient-end dark:opacity-70"></div>
	<?php 
}
?>
    <div class="container mx-auto px-half-gutter flex items-center text-sm relative">
		<?php 
/**
 * Hook - villar_action_primary_navbar
 *
 * @hooked villar_add_mobile_menu_toggle            - 0
 * @hooked villar_add_site_branding                 - 5
 * @hooked villar_add_primary_menu                  - 10
 * @hooked villar_add_social_menu                   - 40
 * @hooked villar_add_header_cart                   - 50
 * @hooked villar_add_function_menu                 - 60
 */
do_action( 'villar_action_primary_navbar' );
?>
    </div>
</div>