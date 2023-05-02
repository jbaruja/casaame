<?php
/**
 * Template for Villar.
 *
 * Template name: Villar: Container And No Margin Template
 */

remove_filter( 'villar_filter_header_class', 'villar_add_header_margin' );

get_header();

// template content
set_query_var( 'villar_template_width', 'container' );
get_template_part( 'template-parts/content', 'template' );

get_footer();
