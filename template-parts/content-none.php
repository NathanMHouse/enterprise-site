<?php
/**
 * Content None Template
 *
 * Content template part for displaying content when no posts can be found (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

$post_type = $wp_query->query_vars['post_type'];
?>
<div class="none-content cell large-6 large-offset-3 medium-8 medium-offset-2">

	<header class="none-content-header">
		<?php
		if ( is_post_type_archive() ) {
			printf(
				wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( '<h2>No %1$s found.</h2>', 'enterprise-site' ),
					array(
						'h2' => array(),
					)
				),
				esc_html( get_post_type_object( $post_type )->name )
			);
		} elseif ( is_search() ) {
			?>
			<h2><?php esc_html_e( 'No results.', 'enterprise-site' ); ?></h2>
			<?php
		} else {
			?>
			<h2><?php esc_html_e( 'Nothing found.', 'enterprise-site' ); ?></h2>
			<?php
		}
		?>
	</header><!-- .none-content-header -->

	<main class="none-content-main">
		<?php
		if ( is_post_type_archive() ) {

			$description = ( get_field( 'no_results_description_' . $post_type, 'options' ) ) ?: '';
			?>
			<h4><?php echo esc_html( $description ); ?></h4>
			<?php
		} elseif ( is_search() ) {
			?>
			<h4><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'enterprise-site' ); ?></h4>
			<?php
				get_search_form();
		} else {
			?>
			<h4><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'enterprise-site' ); ?></h4>
			<?php
				get_search_form();
		}
		?>
	</main><!-- .none-content-main -->
</div><!-- .none-content -->
