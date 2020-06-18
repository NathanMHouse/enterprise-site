<?php
/**
 * 404 Template
 *
 * The template for display not found 404 pages (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
get_header();

get_template_part( 'template-parts/module', 'banner' );
get_template_part( 'template-parts/module', 'breadcrumbs' );
?>
	<section class="error-404 padding-both">
		<div class="grid-container">
			<div class="grid-x grid-margin-x">
				<div class="cell large-6 large-offset-3 medium-8 medium-offset-2">
					<h2><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'enterprise-site' ); ?></h2>
					<?php
					get_search_form();
					?>
				</div><!-- .cell -->
			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .error-404 -->
<?php
get_template_part( 'template-parts/module', 'global-cta' );
get_footer();
