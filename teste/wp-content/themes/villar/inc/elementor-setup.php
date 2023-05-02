<?php

if ( ! function_exists( 'villar_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function villar_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'villar_filter_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'villar_register_elementor_locations' );

if ( ! function_exists( 'villar_wordpress_widget_support_for_elementor' ) ) {
	/**
	 * Support wordpress widget.
	 */
	function villar_wordpress_widget_support_for_elementor( $default_widget_args, $widget_wordpress ) {
		$widget = $widget_wordpress->get_widget_instance();
		$id     = str_replace( 'REPLACE_TO_ID', $widget_wordpress->get_id(), $widget->id );

		$default_widget_args['before_widget'] = sprintf( '<aside id="%1$s" class="widget clearfix %2$s">', $id, $widget->widget_options['classname'] );
		$default_widget_args['after_widget']  = '</aside>';
		$default_widget_args['before_title']  = '<div class="overflow-hidden text-center"><h3 class="reset widget-title inline-block text-h5 uppercase font-serif text-light-title dark:text-dark-title mb-16">';
		$default_widget_args['after_title']   = '</h3></div>';

		return $default_widget_args;
	}
}
add_filter( 'elementor/widgets/wordpress/widget_args', 'villar_wordpress_widget_support_for_elementor', 10, 2 );
