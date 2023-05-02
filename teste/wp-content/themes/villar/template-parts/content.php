<?php

/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Villar
 */
$archive_image = get_villar_setting( 'villar_archive_image' );
$has_sidebar = get_villar_archive_layout() !== 'no-sidebar';
$is_list_style = get_villar_setting( 'villar_archive_style' ) === 'list';
$grid_entry_width = ( $has_sidebar ? 'md:w-1/2' : 'md:w-1/2 lg:w-1/3' );
$is_rounded_thumb = get_villar_setting( 'villar_entry_thumbnail_style' ) === 'round';
$post_class = [ 'entry rounded overflow-hidden flex flex-col items-center h-full' ];
$post_class[] = villar_get_border_style( get_villar_setting( 'villar_entry_border_style' ) );
$post_class[] = ( is_sticky() ? 'bg-light-highlight dark:bg-dark-highlight' : 'bg-light dark:bg-dark' );
if ( $is_list_style ) {
    $post_class[] = 'sm:flex-row';
}
$thumb_wrap_clsx = [ 'image-zoom mask-image overflow-hidden h-260 flex-shrink-0' ];
$thumb_wrap_clsx[] = ( $is_rounded_thumb ? 'w-260 m-gutter rounded-full' : 'w-full' );
if ( $is_list_style ) {
    $thumb_wrap_clsx[] = 'sm:w-260';
}
$entry_structure = array(
    'category',
    'tags',
    'title',
    'excerpt',
    'read-more-metas'
);
$metas_structure = array( 'posted_on', 'views', 'comments' );
?>

<div class="w-full p-half-gutter <?php 
echo  esc_attr( ( $is_list_style ? '' : $grid_entry_width ) ) ;
?>">
    <article id="post-<?php 
the_ID();
?>" <?php 
post_class( $post_class );
?>>
		<?php 

if ( has_post_thumbnail() && !get_villar_setting( 'villar_disable_thumbnail' ) ) {
    ?>
            <a href="<?php 
    the_permalink();
    ?>" class="<?php 
    echo  implode( ' ', $thumb_wrap_clsx ) ;
    ?>">
				<?php 
    the_post_thumbnail( esc_attr( $archive_image ), [
        'class' => 'w-full h-full object-cover rounded-none',
    ] );
    ?>
            </a><!-- /.entry-thumbnail-->
		<?php 
}

?>

        <div class="p-gutter flex flex-col justify-center flex-grow w-full <?php 
echo  esc_attr( ( $is_list_style ? 'sm:w-0' : '' ) ) ;
?>">
			<?php 
foreach ( $entry_structure as $item ) {
    ?>
				<?php 
    
    if ( $item === 'title' ) {
        ?>
                    <div class="mb-half-gutter last:mb-0">
						<?php 
        
        if ( is_singular() ) {
            the_title( '<h1 class="m-0 inline flex-shrink-0">', '</h1>' );
        } else {
            the_title( '<h2 class="m-0 inline flex-shrink-0 text-h5 text-light-title dark:text-dark-title"><a class="transition-all duration-500 link-underline hover:link-underline-full" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }
        
        edit_post_link( esc_html__( 'Edit', 'villar' ), '<span class="text-sm mx-half-gutter hover:text-primary">', '</span>' );
        ?>
                    </div>
				<?php 
    }
    
    ?>
				<?php 
    
    if ( $item === 'excerpt' ) {
        ?>
                    <div class="text-sm mb-half-gutter last:mb-0">
                        <p class="line-clamp-2 mb-0">
							<?php 
        echo  get_the_excerpt() ;
        ?>
                        </p>
                    </div>
				<?php 
    }
    
    ?>
				<?php 
    
    if ( $item === 'read-more-metas' ) {
        ?>
                    <div class="flex justify-between items-center mb-half-gutter last:mb-0">
						<?php 
        
        if ( !get_villar_setting( 'villar_disable_read_more' ) ) {
            ?>
                            <a class="text-light-title-secondary dark:text-dark-title-secondary link-accent-hidden hover:link-accent"
                               href="<?php 
            the_permalink();
            ?>" rel="bookmark">
								<?php 
            echo  esc_html__( 'Read More', 'villar' ) ;
            ?>
                                <span class="screen-reader-text"><?php 
            the_title();
            ?></span>
                            </a>
						<?php 
        }
        
        ?>
                        <div class="text-xs entry-meta">
							<?php 
        villar_post_meta( $metas_structure );
        ?>
                        </div>
                    </div>
				<?php 
    }
    
    ?>
				<?php 
    if ( $item === 'category' ) {
        villar_post_categories( '<div class="flex-shrink-0 mb-half-gutter last:mb-0 whitespace-nowrap overflow-hidden">', '</div>' );
    }
    if ( $item === 'tags' ) {
        villar_post_tags( '<div class="text-sm mb-half-gutter last:mb-0">', '</div>' );
    }
    ?>
			<?php 
}
?>
        </div>
    </article>
</div>