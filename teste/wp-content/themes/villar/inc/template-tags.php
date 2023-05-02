<?php

if ( ! function_exists( 'villar_post_meta' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function villar_post_meta( $items = [ 'posted_on', 'views', 'comments' ] ) {
		$link_class = 'reset hover:text-primary';

		foreach ( $items as $item ) {

			if ( 'byline' === $item ) {

				$byline = sprintf(
					'%s',
					'<span class="author vcard"><a class="' . $link_class . '" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
				);

				if ( ! empty( $byline ) ) {
					echo '<span class="pr-half-gutter byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
				}
			}

			if ( 'views' === $item ) {
				$views = villar_post_views();
				if ( $views >= 0 ) {
					echo '<span class="pr-half-gutter views">' . $views . '</span>';
				}
			}

			if ( 'comments' === $item && comments_open( get_the_ID() ) ) {
				echo '<span class="pr-half-gutter comments-link">';
				comments_popup_link( '0', '1', '%', $link_class );
				echo '</span>';
			}

			if ( 'posted_on' === $item ) {
				$time_string = '<time class="published updated" datetime="%1$s">%2$s</time>';
				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string = '<time class="published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
				}

				$time_string = sprintf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date( 'Y-m-d' ) ),
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date( 'Y-m-d' ) )
				);

				$posted_on = sprintf(
					'%s',
					'<a class="' . $link_class . '" href="' . esc_url( get_permalink() ) . '" rel="bookmark"><span class="entry-date">' . $time_string . '</span></a>'
				);

				if ( ! empty( $posted_on ) ) {
					echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
				}
			}

			if ( 'tags' === $item ) {
				villar_post_tags( '<span class="pl-8">', '</span>' );
			}
		}
	}
}

if ( ! function_exists( 'villar_post_tags' ) ) {
	/**
	 * Prints HTML with tags information for the current post.
	 */
	function villar_post_tags( $before = '', $after = '' ) {
		// Hide tag text for pages.
		if ( 'post' !== get_post_type() ) {
			return;
		}

		$tags = get_the_tags();

		if ( is_wp_error( $tags ) || empty( $tags ) ) {
			return;
		}

		$tag_links = array_map( function ( $tag ) {
			return '<a class="reset link-accent-hidden hover:link-accent" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" rel="tag">' . $tag->name . '</a>';
		}, $tags );

		$before .= '<i class="text-xs fas fa-tags pr-6"></i>';

		/* Translators: used between list items, there is a space after the comma. */
		echo $before . implode( esc_html__( ', ', 'villar' ), $tag_links ) . $after;
	}
}

if ( ! function_exists( 'villar_post_categories' ) ) {
	/**
	 * Prints HTML with categories information for the current post.
	 */
	function villar_post_categories( $before = '', $after = '' ) {
		// Hide category for pages.
		if ( 'post' !== get_post_type() || empty( get_the_category() ) ) {
			return;
		}

		global $wp_rewrite;

		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
		echo $before;
		foreach ( get_the_category() as $category ) {
			echo '<a class="reset v-button-gradient hover:bg-right-center mr-half-gutter" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
		}
		echo $after;
	}
}

if ( ! function_exists( 'villar_categorized_blog' ) ) {
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	function villar_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'villar_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( [
				'fields' => 'ids',

				// We only need to know if there is more than one category.
				'number' => 2,
			] );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'villar_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so villar_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so villar_categorized_blog should return false.
			return false;
		}
	}
}

