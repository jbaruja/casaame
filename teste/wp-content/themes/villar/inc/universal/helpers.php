<?php

if ( ! function_exists( 'villar_get_posts' ) ) {
	/**
	 * Get the posts under the category.
	 *
	 * @return \WP_Query
	 */
	function villar_get_posts( $number_of_posts, $category = '0' ) {
		$query_args = [
			'posts_per_page'      => absint( $number_of_posts ),
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
		];

		if ( absint( $category ) > 0 ) {
			$query_args['cat'] = absint( $category );
		}

		return new \WP_Query( $query_args );
	}
}

if ( ! function_exists( 'villar_get_border_style' ) ) {
	/**
	 * Get border style.
	 */
	function villar_get_border_style( $style ) {
		$styles = [
			'none'   => '',
			'border' => 'border border border-light-and-dark',
			'shadow' => 'border-shadow-light-and-dark',
		];

		if ( isset( $styles[ $style ] ) ) {
			return $styles[ $style ];
		}

		return '';
	}
}

if ( ! function_exists( 'villar_coalescing' ) ) {
	/**
	 * Just like `??` operator after php7.0
	 *
	 * @param $arr
	 * @param $key
	 * @param $default
	 *
	 * @return mixed
	 */
	function villar_coalescing( $arr, $key, $default ) {
		if ( isset( $arr[ $key ] ) && $arr[ $key ] !== '' ) {
			return $arr[ $key ];
		}

		return $default;
	}
}
