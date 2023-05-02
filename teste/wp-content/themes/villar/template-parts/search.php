<?php
/**
 * The template for search result page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Villar
 */
?>

<?php if ( have_posts() ): ?>
    <header class="container mx-auto px-half-gutter mb-gutter">
        <h1 class="text-h4 text-light-title-secondary dark:text-dark-title-secondary">
			<?php
			/* translators: %s: Keywords searched by users */
			printf( esc_html__( 'Search Results for: %s', 'villar' ), '<span>' . get_search_query() . '</span>' );
			?>
        </h1>
    </header>
<?php endif; ?>

<?php get_template_part( 'template-parts/loop' ) ?>
