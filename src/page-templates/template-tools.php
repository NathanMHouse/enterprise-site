<?php
/**
 * Template Name: Tools
 *
 * Page template which uses React to display SPA tools.
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/module', 'banner' );
		get_template_part( 'template-parts/module', 'breadcrumbs' );

		$tool = ( get_field( 'tool' ) ) ?: '';
		?>
		<section
			id="<?php echo esc_attr( $tool ); ?>"
			class="tool-content">
		</section><!-- .tool-content -->
		<?php
		get_template_part( 'template-parts/module', 'image-and-text' );
		get_template_part( 'template-parts/module', 'global-cta' );
	}
}
get_footer();
