<?php
/**
 * Template for Villar.
 *
 * Template name: Villar: Full Width Template
 */

get_header();

// template content
set_query_var( 'villar_template_width', 'full' );
get_template_part( 'template-parts/content', 'template' );

get_footer();
