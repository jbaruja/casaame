<?php
/**
 * The template for archive page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Villar
 */
?>

<?php if ( have_posts() ): ?>
    <header class="container mx-auto px-half-gutter mb-gutter">
		<?php
		the_archive_title( '<h1 class="text-h4 text-light-title-secondary dark:text-dark-title-secondary">', '</h1>' );
		the_archive_description( '<div class="text-sm mt-12">', '</div>' );
		?>
    </header>
<?php endif; ?>

<?php get_template_part( 'template-parts/loop' ) ?>
