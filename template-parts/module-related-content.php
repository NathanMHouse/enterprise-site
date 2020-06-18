<?php
/**
 * Related Content Module
 *
 * Module template for displaying the related content (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

$related_posts = enterprise_site_return_related_posts(
	get_the_ID(),
	get_post_taxonomies( $post )
);

if ( $related_posts ) {
	?>
	<section class="module-related-content">
		<div
			class="grid-container"
			data-equalizer="title"
			data-equalizer-on="medium"
		>
			<div
				class="grid-x grid-margin-x"
				data-equalizer="excerpt"
				data-equalizer-on="medium"
				data-equalize-by-row="true"
			>
				<div class="module-related-content-title cell medium-12">
					<h2><?php esc_html_e( 'Related content', 'enterprise-site' ); ?></h2>
				</div><!-- .mdoule-post-related-content-title -->
				<?php
				foreach ( $related_posts as $post ) {
					setup_postdata( $post );
					include( locate_template( '/template-parts/content-custom-posts-excerpt.php', false, false ) );
				}
				?>
			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- module-related-content -->
	<?php
	wp_reset_postdata();
}
