<?php
/**
 * Single Template
 *
 * The template for displaying single posts (dist).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_format() );
			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
