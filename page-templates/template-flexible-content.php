<?php
/**
 * Template Name: Flexible Content
 *
 * Page template which makes use of the core flexible content setup (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		if ( ! is_front_page() ) {
			get_template_part( 'template-parts/module', 'banner' );
			get_template_part( 'template-parts/module', 'breadcrumbs' );
		}

		get_template_part( 'template-parts/content', 'flexible-content' );

		if ( ! is_front_page() ) {
			get_template_part( 'template-parts/module', 'global-cta' );
		}
	}
}
get_footer();
