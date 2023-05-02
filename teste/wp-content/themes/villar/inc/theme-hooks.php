<?php

if ( !function_exists( 'villar_doctype' ) ) {
    /**
     * Doctype Declaration.
     */
    function villar_doctype()
    {
        $clsx = apply_filters( 'villar_filter_html_class', [] );
        remove_filter( 'body_class', 'villar_add_scope_class' );
        echo  '<!DOCTYPE html><html ' . get_language_attributes() . ' class="' . implode( ' ', $clsx ) . '">' ;
    }

}
add_action( 'villar_action_doctype', 'villar_doctype', 10 );
if ( !function_exists( 'villar_head' ) ) {
    /**
     * Head tags.
     */
    function villar_head()
    {
        ?>
        <meta charset="<?php 
        bloginfo( 'charset' );
        ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="profile" href="http://gmpg.org/xfn/11">
		<?php 
        
        if ( is_singular() && pings_open() ) {
            ?>
            <link rel="pingback" href="<?php 
            bloginfo( 'pingback_url' );
            ?>">
		<?php 
        }
    
    }

}
add_action( 'villar_action_head', 'villar_head' );
if ( !function_exists( 'villar_add_preloader' ) ) {
    /**
     * Add preloader
     */
    function villar_add_preloader()
    {
        if ( get_villar_setting( 'villar_disable_preloader' ) ) {
            return;
        }
        get_template_part( 'template-parts/preloader' );
    }

}
add_action( 'villar_action_before', 'villar_add_preloader' );
if ( !function_exists( 'villar_add_header_open' ) ) {
    /**
     * Add header open.
     */
    function villar_add_header_open()
    {
        ?>
        <header class="<?php 
        villar_header_class();
        ?>">
		<?php 
    }

}
add_action( 'villar_action_before_header', 'villar_add_header_open' );
if ( !function_exists( 'villar_add_header_close' ) ) {
    /**
     * Add header close.
     */
    function villar_add_header_close()
    {
        echo  '</header>' ;
    }

}
add_action( 'villar_action_after_header', 'villar_add_header_close' );
if ( !function_exists( 'villar_add_header_top_bar' ) ) {
    /**
     * Add header top bar.
     */
    function villar_add_header_top_bar()
    {
        if ( get_villar_setting( 'villar_disable_top_bar' ) ) {
            return;
        }
        get_template_part( 'template-parts/header', 'top-bar' );
    }

}
add_action( 'villar_action_header', 'villar_add_header_top_bar', 10 );
if ( !function_exists( 'villar_add_header_banner' ) ) {
    /**
     * Add header banner.
     */
    function villar_add_header_banner()
    {
        if ( get_villar_setting( 'villar_disable_header_banner' ) ) {
            return;
        }
        get_template_part( 'template-parts/header', 'banner' );
    }

}
add_action( 'villar_action_header', 'villar_add_header_banner', 20 );
if ( !function_exists( 'villar_add_primary_navbar' ) ) {
    /**
     * Add primary navbar.
     */
    function villar_add_primary_navbar()
    {
        get_template_part( 'template-parts/header', 'navbar' );
    }

}
add_action( 'villar_action_header', 'villar_add_primary_navbar', 30 );
if ( !function_exists( 'villar_add_top_menu' ) ) {
    /**
     * Add top menu.
     */
    function villar_add_top_menu()
    {
        $clsx = [
            'flex-grow',
            'text-sm',
            'mb-half-gutter',
            'lg:mb-0',
            'text-light-title-secondary',
            'dark:text-dark-title-secondary',
            'uppercase' => get_villar_setting( 'villar_top_menu_text_uppercase' )
        ];
        wp_nav_menu( array(
            'container'       => 'div',
            'container_class' => villar_clsx( $clsx ),
            'theme_location'  => 'top-menu',
            'menu_class'      => 'inline-menu lg:justify-start',
            'fallback_cb'     => 'villar_top_menu_fallback',
            'depth'           => 1,
        ) );
    }

}
add_action( 'villar_action_top_bar', 'villar_add_top_menu' );
if ( !function_exists( 'villar_add_top_social_menu' ) ) {
    /**
     * Add social menu to top bar.
     */
    function villar_add_top_social_menu()
    {
        if ( get_villar_setting( 'villar_disable_top_bar_social_menu' ) ) {
            return;
        }
        if ( has_nav_menu( 'social' ) !== true ) {
            return;
        }
        wp_nav_menu( [
            'theme_location'  => 'social',
            'container'       => 'div',
            'container_class' => 'flex justify-center',
            'depth'           => 1,
            'menu_class'      => 'villar-social-menu clearfix',
            'link_before'     => '<span class="screen-reader-text">',
            'link_after'      => '</span>',
        ] );
    }

}
add_action( 'villar_action_top_bar', 'villar_add_top_social_menu' );
if ( !function_exists( 'villar_add_mobile_menu_toggle' ) ) {
    /**
     * Toggle button for primary menu for mobile.
     */
    function villar_add_mobile_menu_toggle()
    {
        ?>
        <button id="mobile-menu-toggle" class="mobile-menu-toggle block lg:hidden text-light-title dark:text-dark-title pr-half-gutter">
            <i id="mobile-menu-toggle-icon" class="fas fa-bars"></i>
            <span class="screen-reader-text"><?php 
        esc_html_e( 'Mobile Menu Toggle', 'villar' );
        ?></span>
        </button><!-- /.mobile-menu-toggle -->
		<?php 
    }

}
add_action( 'villar_action_primary_navbar', 'villar_add_mobile_menu_toggle', 0 );
if ( !function_exists( 'villar_add_site_branding' ) ) {
    /**
     * Add site branding.
     */
    function villar_add_site_branding()
    {
        $clsx = array( 'site-brand text-light-title dark:text-dark-title text-h3 uppercase font-bold flex-grow lg:flex-grow-0' );
        ?>
        <div class="<?php 
        villar_clsx_echo( $clsx );
        ?>">
			<?php 
        
        if ( get_villar_setting( 'villar_disable_site_brand' ) !== true ) {
            ?>
                <a href="<?php 
            echo  esc_url( home_url( '/' ) ) ;
            ?>">
                    <?php 
            villar_custom_logo();
            ?>
                </a>
			<?php 
        }
        
        ?>
        </div>
		<?php 
    }

}
add_action( 'villar_action_primary_navbar', 'villar_add_site_branding', 5 );
if ( !function_exists( 'villar_add_primary_menu' ) ) {
    /**
     * Add primary menu.
     */
    function villar_add_primary_menu()
    {
        $clsx = array(
            'hidden',
            'lg:block',
            'absolute',
            'lg:relative',
            'top-full',
            'text-light-title',
            'dark:text-dark-title',
            'clear-both',
            'flex-grow',
            'text-base',
            'px-0',
            'lg:px-gutter',
            'uppercase' => get_villar_setting( 'villar_navigation_text_uppercase' ),
            'right-0' => is_rtl(),
            'left-0' => !is_rtl()
        );
        ?>
        <nav data-redirect-focus="#mobile-menu-toggle" id="primary-menu" class="<?php 
        villar_clsx_echo( $clsx );
        ?>">
			<?php 
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'sf-menu primary-menu clearfix',
            'container'      => '',
            'fallback_cb'    => 'villar_primary_navigation_fallback',
        ) );
        ?>
        </nav><!-- /.primary-menu -->
		<?php 
    }

}
add_action( 'villar_action_primary_navbar', 'villar_add_primary_menu', 10 );
if ( !function_exists( 'villar_add_social_menu' ) ) {
    /**
     * Add social menu to header.
     */
    function villar_add_social_menu()
    {
        if ( get_villar_setting( 'villar_disable_navbar_social_menu' ) ) {
            return;
        }
        ?>
		<?php 
        
        if ( has_nav_menu( 'social' ) ) {
            ?>
            <div class="flex-shrink-0 flex items-center mr-8">
				<?php 
            wp_nav_menu( [
                'theme_location' => 'social',
                'container'      => false,
                'depth'          => 1,
                'menu_class'     => 'villar-social-menu clearfix',
                'link_before'    => '<span class="screen-reader-text">',
                'link_after'     => '</span>',
            ] );
            ?>
            </div>
		<?php 
        }
        
        ?>
		<?php 
    }

}
add_action( 'villar_action_primary_navbar', 'villar_add_social_menu', 40 );
if ( !function_exists( 'villar_add_function_menu' ) ) {
    /**
     * Function menu of header.
     */
    function villar_add_function_menu()
    {
        $clsx = [
            'nav-search-form',
            'hidden',
            'w-full',
            'md:w-1/2',
            'lg:w-1/3',
            'absolute',
            'top-full',
            'p-half-gutter',
            'border',
            'border-light-border',
            'dark:border-dark-border',
            'bg-light',
            'dark:bg-dark'
        ];
        $clsx[] = ( is_rtl() ? 'left-0' : 'right-0' );
        ?>
        <div class="flex-shrink-0 text-light-title dark:text-dark-title text-xs">
			<?php 
        
        if ( get_villar_setting( 'villar_disable_color_mode_switcher' ) !== true ) {
            ?>
                <button type="button" class="appearance-none transition-colors duration-200 color-mode-toggle hover:text-primary focus:text-primary cursor-pointer pl-8">
                    <span class="screen-reader-text"><?php 
            esc_html_e( 'Color Mode Toggle', 'villar' );
            ?></span>
                </button>
			<?php 
        }
        
        ?>
			<?php 
        
        if ( get_villar_setting( 'villar_disable_search_button' ) !== true ) {
            ?>
                <button id="nav-search-toggle" type="button" class="appearance-none transition-colors duration-200 nav-search-toggle hover:text-primary focus:text-primary cursor-pointer pl-8">
                    <i class="fas fa-search"></i>
                    <span class="screen-reader-text"><?php 
            esc_html_e( 'Search Modal Toggle', 'villar' );
            ?></span>
                </button>
			<?php 
        }
        
        ?>
        </div><!-- /.color-mode-and-search -->
        <div data-redirect-focus="#nav-search-toggle" class="<?php 
        villar_clsx_echo( $clsx );
        ?>">
			<?php 
        get_search_form();
        ?>
        </div>
		<?php 
    }

}
add_action( 'villar_action_primary_navbar', 'villar_add_function_menu', 60 );
if ( !function_exists( 'villar_add_primary_sidebar' ) ) {
    /**
     * Add primary sidebar.
     */
    function villar_add_primary_sidebar( $layout )
    {
        // Include primary sidebar.
        if ( 'no-sidebar' !== $layout ) {
            get_sidebar();
        }
    }

}
add_action( 'villar_action_sidebar', 'villar_add_primary_sidebar' );
if ( !function_exists( 'villar_custom_posts_navigation' ) ) {
    /**
     * Posts navigation.
     */
    function villar_custom_posts_navigation()
    {
        global  $wp_query ;
        // Don't print empty markup in archives if there's only one page.
        if ( $wp_query->max_num_pages < 2 && (is_home() || is_archive() || is_search()) ) {
            return;
        }
        $navigation_args = [
            'prev_text'          => '<span><i class="fa fa-angle-double-left"></i> ' . esc_html__( 'Prev', 'villar' ) . '</span>',
            'next_text'          => '<span>' . esc_html__( 'Next', 'villar' ) . ' <i class="fa fa-angle-double-right"></i></span>',
            'screen_reader_text' => '<span class="nav-subtitle screen-reader-text">' . esc_html__( 'Page', 'villar' ) . ' </span>',
        ];
        $pagination_type = get_villar_setting( 'villar_archive_pagination' );
        echo  '<div class="px-half-gutter mb-40">' ;
        
        if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
            // Support infinite scroll plugins.
            the_posts_navigation( $navigation_args );
        } elseif ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
            the_posts_pagination( $navigation_args );
        } else {
            the_posts_navigation( $navigation_args );
        }
        
        echo  '</div>' ;
    }

}
add_action( 'villar_action_posts_navigation', 'villar_custom_posts_navigation' );
if ( !function_exists( 'villar_add_footer_widgets' ) ) {
    /**
     * Add footer widgets.
     */
    function villar_add_footer_widgets()
    {
        get_template_part( 'template-parts/footer', 'widgets' );
    }

}
add_action( 'villar_action_before_footer', 'villar_add_footer_widgets', 10 );
if ( !function_exists( 'villar_footer_start' ) ) {
    /**
     * Footer start.
     */
    function villar_footer_start()
    {
        // Check if footer is disabled.
        if ( true !== apply_filters( 'villar_filter_footer_status', true ) ) {
            return;
        }
        echo  '<footer class="text-sm bg-light-highlight dark:bg-dark border-t border-light-border dark:border-dark-border"><div class="container mx-auto py-gutter text-center">' ;
    }

}
add_action( 'villar_action_before_footer', 'villar_footer_start', 20 );
if ( !function_exists( 'villar_footer_end' ) ) {
    /**
     * Footer end.
     */
    function villar_footer_end()
    {
        // Check if footer is disabled.
        if ( true !== apply_filters( 'villar_filter_footer_status', true ) ) {
            return;
        }
        echo  '</div></footer>' ;
    }

}
add_action( 'villar_action_after_footer', 'villar_footer_end' );
if ( !function_exists( 'villar_footer_menu' ) ) {
    function villar_footer_menu()
    {
        // Check if footer is disabled.
        if ( true !== apply_filters( 'villar_filter_footer_status', true ) ) {
            return;
        }
        
        if ( has_nav_menu( 'footer' ) ) {
            $clsx = array( 'inline-menu pb-4 mb-8 clearfix', 'uppercase' => get_villar_setting( 'villar_footer_menu_text_uppercase' ) );
            wp_nav_menu( array(
                'theme_location'  => 'footer',
                'container'       => 'div',
                'container_class' => 'text-center',
                'depth'           => 1,
                'menu_class'      => implode( ' ', $clsx ),
                'fallback_cb'     => false,
            ) );
        }
    
    }

}
add_action( 'villar_action_footer', 'villar_footer_menu', 10 );
if ( !function_exists( 'villar_footer_copyright' ) ) {
    /**
     * Footer copyright.
     */
    function villar_footer_copyright()
    {
        // Check if footer is disabled.
        if ( true !== apply_filters( 'villar_filter_footer_status', true ) ) {
            return;
        }
        // Copyright content.
        $copyright_text = get_villar_setting( 'villar_copyright_text' );
        ?>
		<?php 
        
        if ( !empty($copyright_text) ) {
            ?>
            <div class="px-half-gutter inline-block">
				<?php 
            echo  wp_kses_post( $copyright_text ) ;
            ?>
            </div>
		<?php 
        }
    
    }

}
add_action( 'villar_action_footer', 'villar_footer_copyright', 20 );
if ( !function_exists( 'villar_footer_credits' ) ) {
    /**
     * Footer credits
     */
    function villar_footer_credits()
    {
        // Check if footer is disabled.
        if ( true !== apply_filters( 'villar_filter_footer_status', true ) ) {
            return;
        }
        ?>
            <div class="px-half-gutter inline-block">
				<?php 
        $theme_data = wp_get_theme();
        $site_info = sprintf(
            /* translators: 1: Year, 2: Site Title with home URL, 3: Privacy Policy Link  */
            _x( '%1$s %2$s %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'villar' ),
            esc_attr( date_i18n( __( 'Y', 'villar' ) ) ),
            '<a class="link-accent-hidden hover:link-accent" href="' . esc_url( home_url( '/' ) ) . '">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>',
            ( function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link() : '' )
        );
        $theme_info = '<span class="sep"> | </span>' . '<a class="link-accent-hidden hover:link-accent" target="_blank" href="' . esc_url( $theme_data->get( 'ThemeURI' ) ) . '">' . esc_html( $theme_data->get( 'Name' ) ) . '</a>' . '&nbsp;' . esc_html__( 'by', 'villar' ) . '&nbsp;<a class="link-accent-hidden hover:link-accent" target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>';
        echo  $site_info . $theme_info ;
        ?>
            </div>
		<?php 
    }

}
add_action( 'villar_action_footer', 'villar_footer_credits', 30 );
if ( !function_exists( 'villar_add_to_top' ) ) {
    /**
     * Add to top.
     */
    function villar_add_to_top()
    {
        if ( get_villar_setting( 'villar_disable_to_top' ) ) {
            return;
        }
        $clsx = [
            'z-50',
            'fixed',
            'bottom-double-gutter',
            'rounded-full',
            'h-60',
            'w-60',
            'flex',
            'items-center',
            'justify-center',
            'bg-light',
            'dark:bg-dark',
            'text-light-title',
            'dark:text-dark-title',
            'shadow-to-top-light',
            'dark:shadow-to-top-dark'
        ];
        $clsx[] = ( is_rtl() ? 'left-double-gutter' : 'right-double-gutter' );
        echo  '<a href="#" class="' . implode( ' ', $clsx ) . '" id="scroll-top"><i class="fa fa-angle-up"></i></a>' ;
    }

}
add_action( 'villar_action_after_footer', 'villar_add_to_top' );
if ( !function_exists( 'villar_show_post_content' ) ) {
    /**
     * Show post content.
     */
    function villar_show_post_content()
    {
        get_template_part( 'template-parts/content', 'single' );
    }

}
add_action( 'villar_action_single_post', 'villar_show_post_content' );
if ( !function_exists( 'villar_add_after_posts_widget_area' ) ) {
    /**
     * Add after posts widget area
     */
    function villar_add_after_posts_widget_area()
    {
        echo  '<div id="sidebar-after-posts-widget-area" class="widgets">' ;
        dynamic_sidebar( 'sidebar-after-posts-widget-area' );
        echo  '</div>' ;
    }

}
add_action( 'villar_action_after_single_post', 'villar_add_after_posts_widget_area', 10 );
if ( !function_exists( 'villar_add_post_navigation' ) ) {
    /**
     * Add post navigation.
     */
    function villar_add_post_navigation()
    {
        the_post_navigation( [
            'prev_text'          => '<span class="block text-left"><i class="fa fa-angle-double-left"></i> ' . esc_html__( 'Prev', 'villar' ) . '</span><span class="block post-title">%title</span>',
            'next_text'          => '<span class="block text-right">' . esc_html__( 'Next', 'villar' ) . ' <i class="fa fa-angle-double-right"></i></span><span class="block post-title">%title</span>',
            'screen_reader_text' => '<span class="nav-subtitle screen-reader-text">' . esc_html__( 'Page', 'villar' ) . '</span>',
            'class'              => 'post-navigation',
        ] );
    }

}
add_action( 'villar_action_after_single_post', 'villar_add_post_navigation', 20 );
if ( !function_exists( 'villar_add_comments' ) ) {
    /**
     * Add post comments.
     */
    function villar_add_comments()
    {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
    }

}
add_action( 'villar_action_after_single_post', 'villar_add_comments', 30 );
add_action( 'villar_action_after_page', 'villar_add_comments' );
if ( !function_exists( 'villar_show_page_content' ) ) {
    /**
     * Show Page Content.
     */
    function villar_show_page_content()
    {
        get_template_part( 'template-parts/content', 'page' );
    }

}
add_action( 'villar_action_page', 'villar_show_page_content' );