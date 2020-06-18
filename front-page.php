<?php
/**
 * Front Page Template
 *
 * Template used to display the front page (dist)
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/module', 'front-page-banner' );
		get_template_part( 'template-parts/content', 'flexible-content' );
	};
}
get_footer();
