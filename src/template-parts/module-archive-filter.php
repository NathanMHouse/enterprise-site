<?php
/**
 * Archive Filter Module
 *
 * Module template for displaying the archive filter (src).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

$post_type = ( get_post_type() ) ?: $wp_query->query['post_type'];

$title       = ( get_field( 'filter_title_' . $post_type, 'options' ) ) ?: '';
$description = ( get_field( 'filter_description_' . $post_type, 'options' ) ) ?: '';
?>

<section class="module-archive-filter">
	<div class="grid-container">
		<form
			id="module-archive-filter-form"
			action="<?php echo esc_attr( '/' . $post_type ); ?>"
			method="post"
		>
			<div class="grid-x grid-margin-x">

				<div class="module-archive-filter-form-intro cell large-3 medium-12">
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $description ); ?></p>
				</div><!-- .module-archive-filter-form-intro -->

				<div class="module-archive-filter-form-content cell large-9 medium-12">

					<?php
					$taxonomies = get_object_taxonomies( $post_type );

					foreach ( $taxonomies as $taxonomy ) {
						$taxonomy_obj = get_taxonomy( $taxonomy );
						$terms        = get_terms(
							$taxonomy,
							array(
								'hide_empty' => false,
							)
						);

						$current_term = (
							isset( $_POST[ $taxonomy ], $_POST['posts_filter_nonce'] ) // input var okay
							&& wp_verify_nonce( sanitize_key( $_POST['posts_filter_nonce'] ), 'filter_posts' ) // input var okay
						)
						? sanitize_text_field( wp_unslash( $_POST[ $taxonomy ] ) ) // input var okay
						: '';

						if (
							is_tax( $taxonomy )
							&& empty( $_POST ) // input var okay
						) {
							$taxonomy_query = get_queried_object();
							$current_term   = $taxonomy_query->slug;
						}
						?>
						<p class="form-field form-field-33">
							<label for="select-<?php echo esc_attr( $taxonomy_obj->name ); ?>">
								<?php echo esc_html( $taxonomy_obj->label ); ?>
							</label>
							<select
								id="select-<?php echo esc_attr( $taxonomy_obj->name ); ?>"
								name="<?php echo esc_attr( $taxonomy_obj->name ); ?>">
								<option value=""><?php echo esc_html( __( 'All ', 'enterprise-site' ) . $taxonomy_obj->label ); ?>
								<?php
								foreach ( $terms as $term ) {
									?>
									<option
										value="<?php echo esc_attr( $term->slug ); ?>"
										<?php
										selected(
											$term->slug,
											$current_term
										);
										?>
									>
										<?php echo esc_html( $term->name ); ?>
									</option>
									<?php
								}
								?>
							</select>
						</p><!-- .form-field -->
						<?php
					}

					$current_search = (
						isset( $_POST['form_field_search'], $_POST['posts_filter_nonce'] ) // input var okay
						&& wp_verify_nonce( sanitize_key( $_POST['posts_filter_nonce'] ), 'filter_posts' ) // Input var okay
					)
					? sanitize_text_field( wp_unslash( $_POST['form_field_search'] ) ) // input var okay
					: '';
					?>

					<p class="form-field form-field-33">
						<label><?php esc_html_e( 'Search query', 'enterprise-site' ); ?></label>
						<input
							type="text"
							name="form_field_search"
							id="form-field-search"
							value="<?php echo esc_attr( $current_search ); ?>"
						>
					</p><!-- .form-field -->

					<?php
					if ( function_exists( 'wp_nonce_field' ) ) {
						wp_nonce_field( 'filter_posts', 'posts_filter_nonce' );
					}
					?>

					<p class="form-field form-field-33 form-field-text-right">
						<button
							class="btn btn-primary"
							id="module-archive-filter-form-input-submit"
						><?php esc_html_e( 'Filter', 'enterprise-site' ); ?></button>
					</p><!-- .form-field -->
				</div><!-- .module-archive-filter-form-content -->

			</div><!-- .grid-x -->
		</form><!-- #module-archive-filter-form -->
	</div><!-- .grid-container -->
</section><!-- .module-archive-filter -->
