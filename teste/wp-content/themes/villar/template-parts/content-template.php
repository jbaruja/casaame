<?php
/**
 * Template content
 */
$layout        = get_villar_page_layout();
$is_full_width = get_query_var( 'villar_template_width' ) === 'full';

$clsx   = [ 'lg:flex' ];
$clsx[] = $layout === 'left-sidebar' ? 'lg:flex-row-reverse' : 'lg:flex-row';
if ( ! $is_full_width ) {
	$clsx[] = 'container mx-auto';
}
?>

<div id="content" class="<?php echo implode( ' ', $clsx ) ?>">
    <div class="w-full lg:w-0 lg:flex-grow lg:flex-shrink-0 text-light-title dark:text-dark-title <?php echo esc_attr( $is_full_width ? '' : 'px-half-gutter' ); ?>">
		<?php
		if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
			echo '<div id="sidebar-front-page-widget-area" class="widgets">';
			dynamic_sidebar( 'sidebar-front-page-widget-area' );
			echo '</div>';
		}

		echo '<div>';
		// posts loop
		while ( have_posts() ) {
			the_post();

			the_content();
		}
		echo '</div>';
		?>
    </div>

	<?php
	/**
	 * Hook - villar_action_sidebar.
	 *
	 * @hooked villar_add_primary_sidebar   - 10;
	 */
	do_action( 'villar_action_sidebar', $layout );
	?>
</div>
