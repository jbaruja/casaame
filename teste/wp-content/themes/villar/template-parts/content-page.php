<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$has_sidebar   = get_villar_page_layout() !== 'no-sidebar';
$is_slim_style = get_villar_page_width() !== 'content-full';

$clsx = [
	'entry-content clearfix',
	'text-light-title-secondary',
	'dark:text-dark-title-secondary',
	'mx-auto',
];

if ( $is_slim_style ) {
	$clsx[] = 'max-w-screen-md';
}

if ( $has_sidebar ) {
	$clsx[] = 'has-sidebar';
}

?>
<div id="content" class="w-full mb-40">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="mb-60 rounded-lg bg-light-highlight dark:bg-dark-highlight">
            <div class="px-30 py-gutter w-full">
				<?php the_title( '<h1 class="text-center text-h1 text-light-title dark:text-dark-title">', '</h1>' ); ?>
            </div>
        </header>

		<?php
		if ( has_post_thumbnail() ) {
			echo '<div class="flex-shrink-0 rounded-b-lg overflow-hidden mb-gutter">';
			the_post_thumbnail( 'villar-feature', [
				'class' => 'w-full h-full object-cover'
			] );
			echo '</div>';
		}
		?>

        <div class="<?php echo implode( ' ', $clsx ) ?>">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'villar' ),
				'after'  => '</div>',
			) );
			?>
        </div>
    </article>
</div>
