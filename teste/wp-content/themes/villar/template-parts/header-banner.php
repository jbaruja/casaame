<?php

/**
 * Template part for banner in header.
 *
 * @package Villar
 */
$show_title = get_villar_setting( 'villar_disable_site_title' ) !== true;
$show_tagline = get_villar_setting( 'villar_disable_tagline' ) !== true;
$identity_class = 'site-identity flex-grow ' . get_villar_setting( 'villar_header_text_alignment' );
$title_class = array( 'site-title text-h1 font-bold m-0 text-light-title dark:text-dark-title', 'uppercase' => get_villar_setting( 'villar_site_title_text_uppercase' ) );
$tagline_class = array( 'site-description text-light-title-secondary dark:text-dark-title-secondary' );
$banner_class = array( 'header-banner relative w-full bg-light-highlight dark:bg-dark-highlight', 'py-60' => true );
?>

<div class="<?php 
villar_clsx_echo( $banner_class );
?>">
    <div class="container relative z-30 mx-auto px-half-gutter md:flex items-center">
		<?php 

if ( $show_title || $show_tagline ) {
    ?>
            <div id="site-identity" class="<?php 
    echo  esc_attr( $identity_class ) ;
    ?>">
				<?php 
    
    if ( true === $show_title ) {
        ?>
                    <p class="<?php 
        villar_clsx_echo( $title_class );
        ?>">
                        <a href="<?php 
        echo  esc_url( home_url( '/' ) ) ;
        ?>" rel="home">
							<?php 
        bloginfo( 'name' );
        ?>
                        </a>
                    </p>
				<?php 
    }
    
    ?>

				<?php 
    
    if ( true === $show_tagline ) {
        ?>
                    <p class="<?php 
        villar_clsx_echo( $tagline_class );
        ?>"><?php 
        bloginfo( 'description' );
        ?></p>
				<?php 
    }
    
    ?>
            </div>
		<?php 
}

?>
		<?php 
if ( !get_villar_setting( 'villar_disable_banner_search' ) ) {
    get_search_form();
}
?>
		<?php 
?>
    </div>
    <div class="mask absolute top-0 left-0 w-full h-full opacity-75 bg-light dark:bg-dark-highlight"></div>
</div>
