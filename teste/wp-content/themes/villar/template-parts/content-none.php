<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

<section class="px-half-gutter mb-60">
    <header class="text-center mb-half-gutter">
        <h1 class="text-h2 text-light-title dark:text-dark-title">
			<?php
			if ( is_404() ) {
				esc_html_e( 'Oops! That page can&rsquo;t be found.', 'villar' );
			} else {
				esc_html_e( 'Nothing Found', 'villar' );
			}
			?>
        </h1>
    </header>

    <div class="text-center">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
            <!-- For Home Page -->
            <p class="mb-gutter text-light-title-secondary dark:text-dark-title-secondary">
				<?php
				printf( wp_kses(
				/*translators: %1$s: the url of 'post-new.php'*/
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'villar' ),
					array( 'a' => array( 'href' => array() ) ) ),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
            </p>
		<?php elseif ( is_search() ) : ?>
            <!-- For Search Result -->
            <p class="mb-gutter text-light-title-secondary dark:text-dark-title-secondary">
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'villar' ); ?>
            </p>
            <div class="max-w-lg mx-auto">
				<?php get_search_form(); ?>
            </div>
		<?php else : ?>
            <!-- For Archive Page -->
            <p class="mb-gutter text-light-title-secondary dark:text-dark-title-secondary">
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'villar' ); ?>
            </p>
            <div class="max-w-lg mx-auto">
				<?php get_search_form(); ?>
            </div>
		<?php endif; ?>
    </div>
</section>
