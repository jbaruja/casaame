<?php
/**
 * Template for Villar.
 *
 * Template name: Villar: Blank Container Template
 */

// document open
get_template_part( 'template-parts/layout/document', 'open' );

// template content
set_query_var( 'villar_template_width', 'container' );
get_template_part( 'template-parts/content', 'template' );

// document close
get_template_part( 'template-parts/layout/document', 'close' );
