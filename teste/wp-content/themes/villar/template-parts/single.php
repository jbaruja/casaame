<?php
/**
 * The template part for single post.
 *
 * @package Villar
 */

$layout = get_villar_single_layout();
?>

<div class="container mx-auto lg:flex <?php echo esc_attr( $layout === 'left-sidebar' ? 'lg:flex-row-reverse' : 'lg:flex-row' ) ?>">
    <div class="content w-full lg:w-0 lg:flex-grow lg:flex-shrink-0">
        <div class="px-half-gutter">
			<?php
			// posts loop
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook - villar_action_before_single_post.
				 */
				do_action( 'villar_action_before_single_post' );

				/**
				 * Hook - villar_action_single_post.
				 *
				 * @hooked villar_show_post_content     - 10
				 */
				do_action( 'villar_action_single_post' );

				echo '<div class="max-w-screen-md mx-auto">';

				/**
				 * Hook - villar_action_after_single_post.
				 *
				 * @hooked villar_add_post_navigation       - 10
				 * @hooked villar_add_after_post_widgets    - 20
				 * @hooked villar_add_comments              - 30
				 */
				do_action( 'villar_action_after_single_post' );

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