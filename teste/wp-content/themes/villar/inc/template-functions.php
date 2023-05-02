<?php

if ( ! function_exists( 'villar_primary_navigation_fallback' ) ) {
	/**
	 * Fallback for primary navigation.
	 */
	function villar_primary_navigation_fallback($args) {
		// for customize menu style, the default one not work.
		wp_page_menu( array_merge( $args, [
			'container' => 'ul'
		] ) );
	}
}

if ( ! function_exists( 'villar_top_menu_fallback' ) ) {
	/**
	 * Fallback for top menu
	 */
	function villar_top_menu_fallback( $args ) {
		// for customize menu style, the default one not work.
		wp_page_menu( array_merge( $args, [
			'container' => 'ul'
		] ) );
	}
}

if ( ! function_exists( 'villar_render_image_radio' ) ) {
	/**
	 * Render image radio.
	 *
	 * @param array $args
	 * @param \Closure $callback
	 * @param array $callback_args
	 *
	 * @return string
	 */
	function villar_render_image_radio( $args, $callback, $callback_args = [] ) {
		$defaults = [
			'id'       => '',
			'name'     => '',
			'selected' => 0,
			'echo'     => true,
		];

		$r       = wp_parse_args( $args, $defaults );
		$output  = '';
		$choices = array();

		if ( is_callable( $callback ) ) {
			$choices = call_user_func_array( $callback, $callback_args );
		}

		if ( ! empty( $choices ) ) {
			$output = '<div id="' . $r['id'] . '" class="villar-image-radio-button-control">';
			foreach ( $choices as $key => $choice ) {
				$output .= '<label class="radio-button-label">';
				$output .= '<input type="radio" id="' . $r['id'] . $key . '" name="' . $r['name'] . '" value="' . $key . '" ';
				$output .= checked( $r['selected'], $key, false );
				$output .= '/>';
				$output .= '<img src="' . $choice['image'] . '" alt="' . $choice['name'] . '" title="' . $choice['name'] . '"/>';
				$output .= '</label>';
			}
			$output .= "</div>\n";
		}

		if ( $r['echo'] ) {
			echo $output;
		}

		return $output;
	}
}

if ( ! function_exists( 'villar_render_select_dropdown' ) ) {
	/**
	 * Render select dropdown.
	 *
	 * @param array $args
	 * @param \Closure $callback
	 * @param array $callback_args
	 *
	 * @return string
	 */
	function villar_render_select_dropdown( $args, $callback, $callback_args = [] ) {
		$defaults = [
			'id'          => '',
			'name'        => '',
			'selected'    => 0,
			'echo'        => true,
			'add_default' => false,
		];

		$r       = wp_parse_args( $args, $defaults );
		$output  = '';
		$choices = [];

		if ( is_callable( $callback ) ) {
			$choices = call_user_func_array( $callback, $callback_args );
		}

		if ( ! empty( $choices ) || true === $r['add_default'] ) {
			$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
			if ( true === $r['add_default'] ) {
				$output .= '<option value="">' . esc_html__( 'Default', 'villar' ) . '</option>\n';
			}
			if ( ! empty( $choices ) ) {
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
			}
			$output .= "</select>\n";
		}

		if ( $r['echo'] ) {
			echo $output;
		}

		return $output;
	}
}

if ( ! function_exists( 'villar_woo_cart_available' ) ) {
	/**
	 * Validates whether the Woo Cart instance is available in the request
	 *
	 * @return bool
	 */
	function villar_woo_cart_available() {
		$woo = WC();

		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
}

if ( ! function_exists( 'villar_cart_link' ) ) {
	/**
	 * Display cart link
	 *
	 * @return string
	 */
	function villar_cart_link() {
		if ( ! villar_woo_cart_available() ) {
			return '';
		}

		$output     = '';
		$cart_count = WC()->cart->cart_contents_count;
		$cart_link  = esc_url( $cart_count ? wc_get_cart_url() : wc_get_page_permalink( 'shop' ) );
		$output     .= '<a class="header-cart-contents whitespace-nowrap" href="' . $cart_link . '">';
		$output     .= '<span class="cart-icon fas fa-shopping-cart relative mr-0 lg:mr-1.5">';
		if ( $cart_count ) {
			$output .= '<span class="cart-badge absolute -top-2.5 -right-2.5 px-1 py-0.5 font-sans font-bold leading-none text-red-100 transform bg-red-600 rounded-full">';
			$output .= WC()->cart->get_cart_contents_count();
			$output .= '</span>';
		}
		$output .= '</span>';
		$output .= '</a>';

		return $output;
	}
}

if ( ! function_exists( 'villar_header_cart_link_fragments' ) ) {
	/**
	 * Update cart with AJAX
	 */
	function villar_header_cart_link_fragments( $fragments ) {
		$fragments['.header-cart-contents'] = villar_cart_link();

		return $fragments;
	}
}
add_filter( 'add_to_cart_fragments', 'villar_header_cart_link_fragments' );

if ( ! function_exists( 'get_villar_header_class' ) ) {
	/**
	 * Get header class.
	 *
	 * @return string
	 */
	function get_villar_header_class() {
		$header_class = apply_filters( 'villar_filter_header_class', [] );

		return implode( ' ', $header_class );
	}
}

if ( ! function_exists( 'villar_header_class' ) ) {
	/**
	 * Echo header class.
	 */
	function villar_header_class() {
		echo get_villar_header_class();
	}
}

if ( ! function_exists( 'villar_post_views' ) ) {
	/**
	 * Gets total post views for a post
	 *
	 * @param int $post_id
	 *
	 * @return int
	 */
	function villar_post_views( $post_id = 0 ) {
		if ( function_exists( 'pvc_get_post_views' ) ) {
			return pvc_get_post_views( $post_id );
		}

		return - 1;
	}
}

if ( ! function_exists( 'villar_custom_logo' ) ) {
	/**
	 * Get custom logo.
	 */
	function villar_custom_logo() {
		$main_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		$dark_logo = wp_get_attachment_image_src( get_villar_setting( 'villar_dark_mode_logo' ), 'full' );

		if ( ! empty( $main_logo ) && is_array( $main_logo ) ) {
			$main_logo = $main_logo[0];
		}
		if ( ! empty( $dark_logo ) && is_array( $dark_logo ) ) {
			$dark_logo = $dark_logo[0];
		}

		// we have a main logo
		if ( empty( $main_logo ) === false ) {
			$alt_attribute = get_post_meta( get_theme_mod( 'custom_logo' ), '_wp_attachment_image_alt', true );
			$alt_attribute = ! empty( $alt_attribute ) ? $alt_attribute : get_bloginfo( 'name' );
			$main_classes  = '';

			// we have a logo for dark mode
			if ( empty( $dark_logo ) === false ) {
				$attachment_id  = attachment_url_to_postid( $dark_logo );
				$dark_attribute = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				$dark_attribute = ! empty( $dark_attribute ) ? $dark_attribute : get_bloginfo( 'name' );
				$main_classes   = 'block dark:hidden';

				echo '<img class="hidden dark:block" src="' . esc_url( $dark_logo ) . '" alt="' . esc_attr( $dark_attribute ) . '" />';
			}

			echo '<img class="' . $main_classes . '" src="' . esc_url( $main_logo ) . '" alt="' . esc_attr( $alt_attribute ) . '" />';
		} else {
			echo esc_html( get_villar_setting( 'villar_brand_text' ) );
		}
	}
}

if ( ! function_exists( 'villar_clsx' ) ) {
	/**
	 * A utility for constructing className strings conditionally.
	 *
	 * @return string
	 */
	function villar_clsx( ...$args ) {
		$classNames = array();

		foreach ( $args as $arg ) {
			if ( is_string( $arg ) ) {
				$classNames[] = $arg;
			} else if ( is_array( $arg ) ) {
				foreach ( $arg as $k => $v ) {
					if ( is_string( $v ) ) {
						$classNames[] = $v;
					} else if ( is_bool( $v ) && $v === true ) {
						$classNames[] = $k;
					}
				}
			}
		}

		return esc_attr( implode( ' ', $classNames ) );
	}
}

if ( ! function_exists( 'villar_clsx_echo' ) ) {
	/**
	 * Echo version for villar_clsx
	 *
	 * @param ...$args
	 */
	function villar_clsx_echo( ...$args ) {
		echo villar_clsx( ...$args );
	}
}
