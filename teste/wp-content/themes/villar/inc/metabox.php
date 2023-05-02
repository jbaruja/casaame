<?php

if ( ! function_exists( 'villar_add_theme_meta_box' ) ) {
	/**
	 * Add the meta box.
	 *
	 * @return void
	 */
	function villar_add_theme_meta_box() {
		$post_types = [ 'post', 'page' ];

		foreach ( $post_types as $type ) {
			add_meta_box(
				'villar-theme-settings',
				esc_html__( 'Villar Theme Settings', 'villar' ),
				'villar_render_theme_settings_metabox',
				$type
			);
		}
	}
}
add_action( 'add_meta_boxes', 'villar_add_theme_meta_box' );

if ( ! function_exists( 'villar_render_theme_settings_metabox' ) ) {
	/**
	 * Render theme settings meta box.
	 */
	function villar_render_theme_settings_metabox() {
		global $post;
		$post_id = $post->ID;

		// Meta box nonce for verification.
		wp_nonce_field( basename( __FILE__ ), 'villar_settings_meta_box_nonce' );

		// Fetch values of current post meta.
		$values = get_post_meta( $post_id, 'villar_settings', true );

		$fields = wp_parse_args( $values, [
			'post_layout'   => '',
			'content_width' => '',
		] ); ?>

        <p><strong><?php esc_html_e( 'Choose Layout', 'villar' ); ?></strong></p>
		<?php

		$dropdown_args = [
			'id'          => 'villar_settings_post_layout',
			'name'        => 'villar_settings[post_layout]',
			'selected'    => $fields['post_layout'],
			'add_default' => true,
		];

		villar_render_image_radio( $dropdown_args, 'villar_get_sidebar_layout_options' );
		?>
        <p><strong><?php esc_html_e( 'Choose Container Style', 'villar' ); ?></strong></p>
		<?php
		$dropdown_args = [
			'id'          => 'villar_settings_content_width',
			'name'        => 'villar_settings[content_width]',
			'selected'    => $fields['content_width'],
			'add_default' => true,
		];

		villar_render_image_radio( $dropdown_args, 'villar_get_container_width_options' );
	}
}

if ( ! function_exists( 'villar_save_theme_settings_meta' ) ) {
	/**
	 * Save theme settings meta box value.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 *
	 * @return void
	 */
	function villar_save_theme_settings_meta( $post_id, $post ) {
		// Verify nonce.
		if (
			! ( isset( $_POST['villar_settings_meta_box_nonce'] )
			    && wp_verify_nonce( sanitize_key( $_POST['villar_settings_meta_box_nonce'] ), basename( __FILE__ ) ) )
		) {
			return;
		}

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || absint( $_POST['post_ID'] ) !== $post_id ) {
			return;
		}

		// Check permission.
		if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['villar_settings'] ) && is_array( $_POST['villar_settings'] ) ) {
			$post_value = wp_unslash( $_POST['villar_settings'] );

			if ( ! array_filter( $post_value ) ) {
				delete_post_meta( $post_id, 'villar_settings' );

				return;
			}

			$meta_fields = [
				'post_layout'   => [
					'type' => 'select',
				],
				'content_width' => [
					'type' => 'select',
				],
			];

			$sanitized_values = [];

			foreach ( $post_value as $mk => $mv ) {
				if ( isset( $meta_fields[ $mk ]['type'] ) ) {
					switch ( $meta_fields[ $mk ]['type'] ) {
						case 'select':
							$sanitized_values[ $mk ] = sanitize_key( $mv );
							break;
						case 'checkbox':
							$sanitized_values[ $mk ] = absint( $mv ) > 0 ? 1 : 0;
							break;
						default:
							$sanitized_values[ $mk ] = sanitize_text_field( $mv );
							break;
					}
				}
			}

			update_post_meta( $post_id, 'villar_settings', $sanitized_values );
		}
	}
}
add_action( 'save_post', 'villar_save_theme_settings_meta', 10, 2 );
