<?php

if ( ! function_exists( 'villar_get_image_sizes_options' ) ) {
	/**
	 * Returns image sizes options.
	 *
	 * @param bool $add_disable true for adding No Image option
	 * @param array $allowed allowed image size options
	 * @param bool $show_dimension true for showing dimension
	 *
	 * @return array image size options
	 */
	function villar_get_image_sizes_options( $add_disable = true, array $allowed = [], $show_dimension = true ) {

		global $_wp_additional_image_sizes;

		$choices = [];

		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'villar' );
		}

		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'villar' );
		$choices['medium']    = esc_html__( 'Medium', 'villar' );
		$choices['large']     = esc_html__( 'Large', 'villar' );
		$choices['full']      = esc_html__( 'Full (original)', 'villar' );

		if ( true === $show_dimension ) {
			foreach ( [ 'thumbnail', 'medium', 'large' ] as $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ) {
					$choices[ $key ] .= ' (' . $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed, true ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;
	}
}

if ( ! function_exists( 'villar_get_sidebar_layout_options' ) ) {
	/**
	 * Returns layout options.
	 *
	 * @return array $choices
	 */
	function villar_get_sidebar_layout_options() {
		return [
			'no-sidebar'    => array(
				'image' => trailingslashit( get_template_directory_uri() ) . 'build/images/sidebar-none.png',
				'name'  => esc_html__( 'No Sidebar', 'villar' )
			),
			'left-sidebar'  => array(
				'image' => trailingslashit( get_template_directory_uri() ) . 'build/images/sidebar-left.png',
				'name'  => esc_html__( 'Left Sidebar', 'villar' )
			),
			'right-sidebar' => array(
				'image' => trailingslashit( get_template_directory_uri() ) . 'build/images/sidebar-right.png',
				'name'  => esc_html__( 'Right Sidebar', 'villar' )
			)
		];
	}
}

if ( ! function_exists( 'villar_get_archive_style_options' ) ) {
	/**
	 * Return archive style options.
	 */
	function villar_get_archive_style_options() {
		return [
			'list' => esc_html__( 'List', 'villar' ),
			'grid' => esc_html__( 'Grid', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_container_width_options' ) ) {
	/**
	 * Return content width options.
	 *
	 * @return array $choices
	 */
	function villar_get_container_width_options() {
		return [
			'content-slim' => array(
				'image' => trailingslashit( get_template_directory_uri() ) . 'build/images/slim-width.png',
				'name'  => esc_html__( 'Slim', 'villar' )
			),
			'content-full' => array(
				'image' => trailingslashit( get_template_directory_uri() ) . 'build/images/full-width.png',
				'name'  => esc_html__( 'Full', 'villar' )
			),
		];
	}
}

if ( ! function_exists( 'villar_get_archive_pagination_options' ) ) {
	/**
	 * Return archive pagination options.
	 *
	 * @return $choices array
	 */
	function villar_get_archive_pagination_options() {
		return [
			'default' => esc_html__( 'Default', 'villar' ),
			'numeric' => esc_html__( 'Numeric', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_sidebar_width_options' ) ) {
	/**
	 * Sidebar width options
	 *
	 * @return array
	 */
	function villar_get_sidebar_width_options() {
		return [
			'lg:w-1/3' => esc_html__( '1/3', 'villar' ),
			'lg:w-1/4' => esc_html__( '1/4', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_css_ease_options' ) ) {
	/**
	 * Get css ease options.
	 */
	function villar_get_css_ease_options() {
		return [
			'linear'                               => esc_html__( 'Linear', 'villar' ),
			'ease'                                 => esc_html__( 'Ease', 'villar' ),
			'ease-in'                              => esc_html__( 'Ease In', 'villar' ),
			'ease-out'                             => esc_html__( 'Ease Out', 'villar' ),
			'ease-in-out'                          => esc_html__( 'Ease In Out', 'villar' ),
			'cubic-bezier(0.47,0,0.745,0.715)'     => esc_html__( 'Ease In Sine', 'villar' ),
			'cubic-bezier(0.39,0.575,0.565,1)'     => esc_html__( 'Ease Out Sine', 'villar' ),
			'cubic-bezier(0.445,0.05,0.55,0.95)'   => esc_html__( 'Ease In Out Sine', 'villar' ),
			'cubic-bezier(0.55,0.085,0.68,0.53)'   => esc_html__( 'Ease In Quad', 'villar' ),
			'cubic-bezier(0.25,0.46,0.45,0.94)'    => esc_html__( 'Ease Out Quad', 'villar' ),
			'cubic-bezier(0.455,0.03,0.515,0.955)' => esc_html__( 'Ease In Out Quad', 'villar' ),
			'cubic-bezier(0.55,0.055,0.675,0.19)'  => esc_html__( 'Ease In Cubic', 'villar' ),
			'cubic-bezier(0.215,0.61,0.355,1)'     => esc_html__( 'Ease Out Cubic', 'villar' ),
			'cubic-bezier(0.645,0.045,0.355,1)'    => esc_html__( 'Ease In Out Cubic', 'villar' ),
			'cubic-bezier(0.895,0.03,0.685,0.22)'  => esc_html__( 'Ease In Quart', 'villar' ),
			'cubic-bezier(0.165,0.84,0.44,1)'      => esc_html__( 'Ease Out Quart', 'villar' ),
			'cubic-bezier(0.77,0,0.175,1)'         => esc_html__( 'Ease In Out Quart', 'villar' ),
			'cubic-bezier(0.755,0.05,0.855,0.06)'  => esc_html__( 'Ease In Quint', 'villar' ),
			'cubic-bezier(0.23,1,0.32,1)'          => esc_html__( 'Ease Out Quint', 'villar' ),
			'cubic-bezier(0.86,0,0.07,1)'          => esc_html__( 'Ease In Out Quint', 'villar' ),
			'cubic-bezier(0.95,0.05,0.795,0.035)'  => esc_html__( 'Ease In Expo', 'villar' ),
			'cubic-bezier(0.19,1,0.22,1)'          => esc_html__( 'Ease Out Expo', 'villar' ),
			'cubic-bezier(1,0,0,1)'                => esc_html__( 'Ease In Out Expo', 'villar' ),
			'cubic-bezier(0.6,0.04,0.98,0.335)'    => esc_html__( 'Ease In Circ', 'villar' ),
			'cubic-bezier(0.075,0.82,0.165,1)'     => esc_html__( 'Ease Out Circ', 'villar' ),
			'cubic-bezier(0.785,0.135,0.15,0.86)'  => esc_html__( 'Ease In Out Circ', 'villar' ),
			'cubic-bezier(0.6,-0.28,0.735,0.045)'  => esc_html__( 'Ease In Back', 'villar' ),
			'cubic-bezier(0.175,0.885,0.32,1.275)' => esc_html__( 'Ease Out Back', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_color_options' ) ) {
	/**
	 * Color Mode options.
	 *
	 * @return array
	 */
	function villar_get_color_options() {
		return [
			'dark'  => esc_html__( 'Dark', 'villar' ),
			'light' => esc_html__( 'Light', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_font_family_options' ) ) {
	/**
	 * Font family options
	 */
	function villar_get_font_family_options() {
		return [
			'font-sans'                => esc_html__( 'Sans', 'villar' ),
			'font-serif'               => esc_html__( 'Serif', 'villar' ),
			'font-mono'                => esc_html__( 'Mono', 'villar' ),
			'font-google-opensans'     => esc_html__( 'Open Sans (Google Fonts)', 'villar' ),
			'font-google-lato'         => esc_html__( 'Lato (Google Fonts)', 'villar' ),
			'font-google-abhaya-libre' => esc_html__( 'Abhaya Libre (Google Fonts)', 'villar' ),
			'font-google-playfair'     => esc_html__( 'Playfair (Google Fonts)', 'villar' ),
			'font-google-rokkitt'      => esc_html__( 'Rokkitt (Google Fonts)', 'villar' ),
			'font-google-kalam'        => esc_html__( 'Kalam (Google Fonts)', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_heading_size_options' ) ) {
	/**
	 * Heading size options.
	 */
	function villar_get_heading_size_options() {
		return [
			'text-h1' => esc_html_x( 'H1', 'heading size', 'villar' ),
			'text-h2' => esc_html_x( 'H2', 'heading size', 'villar' ),
			'text-h3' => esc_html_x( 'H3', 'heading size', 'villar' ),
			'text-h4' => esc_html_x( 'H4', 'heading size', 'villar' ),
			'text-h5' => esc_html_x( 'H5', 'heading size', 'villar' ),
			'text-h6' => esc_html_x( 'H6', 'heading size', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_text_alignment_options' ) ) {
	/**
	 * Text alignment options
	 *
	 * @return array
	 */
	function villar_get_text_alignment_options() {
		return [
			'text-left'   => esc_html__( 'Align Left', 'villar' ),
			'text-center' => esc_html__( 'Align Center', 'villar' ),
			'text-right'  => esc_html__( 'Align Right', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_border_style_options' ) ) {
	/**
	 * Get border style options
	 *
	 * @return array
	 */
	function villar_get_border_style_options() {
		return [
			'none'   => esc_html_x( 'None', 'border style', 'villar' ),
			'border' => esc_html_x( 'Border', 'border style', 'villar' ),
			'shadow' => esc_html_x( 'Shadow', 'border style', 'villar' ),
		];
	}
}

if ( ! function_exists( 'villar_get_thumbnail_style_options' ) ) {
	/**
	 * Return thumbnail style options.
	 *
	 * @return array
	 */
	function villar_get_thumbnail_style_options() {
		return [
			'round'  => esc_attr_x( 'Round', 'thumbnail style', 'villar' ),
			'square' => esc_attr_x( 'Square', 'thumbnail style', 'villar' ),
		];
	}
}
