<?php
/**
 * Hook - villar_action_doctype
 *
 * @hooked villar_doctype   - 10;
 */
do_action( 'villar_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - villar_action_head.
	 *
	 * @hooked villar_head  - 10;
	 */
	do_action( 'villar_action_head' );
	?>

	<?php wp_head(); ?>

	<?php
	/**
	 * Hook - villar_action_after_head.
	 */
	do_action( 'villar_action_after_head' );
	?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content">
	<?php _e( 'Skip to content', 'villar' ); ?>
</a>
<?php
$clsx = apply_filters( 'villar_filter_app_class', array( 'app' ) );
echo '<div class="' . villar_clsx( $clsx ) . '">';
?>
