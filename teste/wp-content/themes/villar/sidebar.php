<?php

/**
 * The default primary sidebar.
 *
 * @see https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
$default_sidebar = apply_filters( 'villar_filter_default_sidebar_id', 'sidebar-1', 'primary' );
$sidebar_width   = get_villar_setting( 'villar_sidebar_width' );
?>

<div class="widgets sidebar-primary px-half-gutter w-full <?php echo esc_attr( $sidebar_width ); ?>"
     role="complementary">
	<?php if ( is_active_sidebar( $default_sidebar ) ): ?>
		<?php dynamic_sidebar( $default_sidebar ); ?>
	<?php else : ?>
		<?php
		/**
		 * Hook - villar_action_default_sidebar.
		 */
		do_action( 'villar_action_default_sidebar', $default_sidebar, 'primary' );
		?>
	<?php endif; ?>
</div>

