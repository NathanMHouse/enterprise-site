<?php
/**
 * Page Template
 *
 * The template for displaying all pages (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
get_header();
if ( have_posts() ) {
	get_template_part( 'template-parts/module', 'banner' );
	get_template_part( 'template-parts/module', 'breadcrumbs' );
	while ( have_posts() ) {
		the_post();

		// Get page content.
		get_template_part( 'template-parts/content', 'page' );
	}
}
get_template_part( 'template-parts/module', 'global-cta' );
get_footer();
