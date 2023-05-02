<?php

/**
 * Template part for displaying single post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
$has_sidebar = get_villar_single_layout() !== 'no-sidebar';
$is_slim_style = get_villar_single_width() !== 'content-full';
$clsx = [
    'entry-content clearfix',
    'text-light-title-secondary',
    'dark:text-dark-title-secondary',
    'mx-auto'
];
if ( $is_slim_style ) {
    $clsx[] = 'max-w-screen-md';
}
if ( $has_sidebar ) {
    $clsx[] = 'has-sidebar';
}
$entry_structure = array(
    'category',
    'title',
    'excerpt',
    'metas'
);
$metas_structure = array(
    'byline',
    'views',
    'comments',
    'posted_on',
    'tags'
);
$has_thumbnail = has_post_thumbnail() && !get_villar_setting( 'villar_disable_featured_image' );
?>
<div id="content" class="w-full mb-40">
    <article id="post-<?php 
the_ID();
?>" <?php 
post_class();
?>>
        <header class="<?php 
villar_clsx_echo( [ 'post-header mb-60 rounded-lg bg-light-highlight dark:bg-dark-highlight md:flex', 'md:h-260' => $has_thumbnail ] );
?>">
            <div class="px-30 py-gutter w-full <?php 
echo  esc_attr( get_villar_setting( 'villar_post_header_text_alignment' ) ) ;
?>">
				<?php 
foreach ( $entry_structure as $item ) {
    ?>
					<?php 
    
    if ( $item === 'title' ) {
        ?>
                        <div class="mb-half-gutter last:mb-0">
							<?php 
        the_title( '<h1 class="text-h1 break-words inline text-light-title dark:text-dark-title">', '</h1>' );
        edit_post_link( esc_html__( 'Edit', 'villar' ), '<span class="text-sm mx-half-gutter hover:text-primary">', '</span>' );
        ?>
                        </div>
					<?php 
    }
    
    ?>
					<?php 
    
    if ( $item === 'category' ) {
        ?>
						<?php 
        villar_post_categories( '<div class="flex-shrink-0 pb-8 whitespace-nowrap overflow-x-auto">', '</div>' );
        ?>
					<?php 
    }
    
    ?>
					<?php 
    
    if ( $item === 'excerpt' ) {
        ?>
                        <div class="text-sm mb-gutter last:mb-0 line-clamp-2">
							<?php 
        echo  get_the_excerpt() ;
        ?>
                        </div>
					<?php 
    }
    
    ?>
					<?php 
    
    if ( $item === 'metas' ) {
        ?>
                        <div class="text-xs entry-meta mb-half-gutter last:mb-0">
							<?php 
        villar_post_meta( $metas_structure );
        ?>
                        </div>
					<?php 
    }
    
    ?>
				<?php 
}
?>
            </div>
			<?php 

if ( $has_thumbnail ) {
    echo  '<div class="post-thumbnail flex-shrink-0 overflow-hidden rounded-b-lg ' . (( is_rtl() ? 'md:rounded-br-none md:rounded-l-lg' : 'md:rounded-bl-none md:rounded-r-lg' )) . '">' ;
    the_post_thumbnail( 'villar-feature', [
        'class' => 'w-full h-full object-cover rounded-none',
    ] );
    echo  '</div>' ;
}

?>
        </header>

        <div class="<?php 
echo  implode( ' ', $clsx ) ;
?>">
			<?php 
the_content();
?>
			<?php 
wp_link_pages( array(
    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'villar' ),
    'after'  => '</div>',
) );
?>
        </div>
    </article>
</div>
