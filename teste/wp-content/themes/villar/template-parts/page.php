<?php
/**
 * The template part for displaying page.
 *
 * @package Villar
 */

$layout = get_villar_page_layout();
?>

<div class="container mx-auto lg:flex <?php echo esc_attr( $layout === 'left-sidebar' ? 'lg:flex-row-reverse' : 'lg:flex-row' ) ?>">
    <div class="content w-full lg:w-0 lg:flex-grow lg:flex-shrink-0">
        <div class="px-half-gutter">
			<?php
			// posts loop
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook - villar_action_before_page.
				 */
				do_action( 'villar_action_before_page' );

				/**
				 * Hook - villar_action_page.
				 *
				 * @hooked villar_show_page_content     - 10
				 */
				do_action( 'villar_action_page' );

				echo '<div class="max-w-screen-md mx-auto">';

				/**
				 * Hook - villar_action_after_page.
				 *
				 * @hooked villar_add_comments  - 10
				 */
				do_action( 'villar_action_after_page' );

				echo '</div>';
			}
			?>
        </div>
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
