<?php
/**
 * Template part for posts loop.
 *
 * @package Villar
 */

$layout = get_villar_archive_layout();
?>

<div class="container mx-auto lg:flex <?php echo esc_attr( $layout === 'left-sidebar' ? 'lg:flex-row-reverse' : 'lg:flex-row' ) ?>">
    <div class="content w-full lg:w-0 lg:flex-grow lg:flex-shrink-0">
		<?php if ( have_posts() ): ?>
            <div id="content" class="-my-half-gutter mb-gutter flex flex-wrap">
				<?php
				// posts loop
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content' );
				}
				?>
            </div>

			<?php
			/**
			 * Hook - villar_action_posts_navigation.
			 *
			 * @hooked villar_custom_posts_navigation   - 10
			 */
			do_action( 'villar_action_posts_navigation' );
			?>
		<?php else: ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
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