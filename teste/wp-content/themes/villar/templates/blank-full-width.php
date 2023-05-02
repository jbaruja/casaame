<?php
/**
 * Template for Villar.
 *
 * Template name: Villar: Blank Full Width Template
 */

// document open
get_template_part( 'template-parts/layout/document', 'open' );

// template content
set_query_var( 'villar_template_width', 'full' );
get_template_part( 'template-parts/content', 'template' );

// document close
get_template_part( 'template-parts/layout/document', 'close' );
