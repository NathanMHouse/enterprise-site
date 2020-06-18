<?php
/**
 * Content Custom Post Template
 *
 * Content template part for displaying custom post content (dist).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
?>
<article
	id="custom-posts-post-<?php the_ID(); ?>"
	<?php post_class(); ?>
>
	<div class="grid-x grid-margin-x">
		<aside class="cell large-3">
			<dl class="custom-posts-post-meta">

				<?php
				$date_toggle = ( 'date_false' === get_field( 'date_toggle' ) )
					? false
					: true;

				if ( $date_toggle ) {
					?>
					<dt class="custom-posts-post-meta-date"><?php esc_html_e( 'Date', 'enterprise-site' ); ?></dt>
					<dd><?php echo get_the_date( 'F j, Y' ); ?></dd>
					<?php
				}
				?>

				<dt class="custom-posts-post-meta-author"><?php esc_html_e( 'Author', 'enterprise-site' ); ?></dt>
				<dd><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></dd>

				<?php
				$taxonomies = get_post_taxonomies( $post );

				foreach ( $taxonomies as $taxonomy ) {
					$taxonomy_object = get_taxonomy( $taxonomy );
					$terms           = wp_get_post_terms(
						$post->ID,
						$taxonomy
					);

					if ( $terms ) {
						?>
						<dt class="custom-posts-post-meta-taxonomy custom-posts-postmeta-taxonomy-<?php echo esc_attr( $taxonomy_object->name ); ?>"><?php echo esc_html( $taxonomy_object->label ); ?></dt>
						<dd>
							<?php
							$term_links = array();

							foreach ( $terms as $term ) {
								$term_link  = '<a href="';
								$term_link .= get_term_link( $term );
								$term_link .= '">';
								$term_link .= $term->name;
								$term_link .= '</a>';

								$term_links[] = $term_link;
							}

							echo wp_kses(
								implode( ', ', $term_links ),
								array(
									'a' => array(
										'href' => array(),
									),
								)
							);
							?>
						</dd>
						<?php
					}
				}
				?>
			</dl><!-- .custom-posts-post-meta -->

			<div class="custom-posts-post-social-share">
				<?php echo do_shortcode( '[addtoany buttons=facebook,twitter,linkedin,email]' ); ?>
			</div><!-- .custom-posts-post-social-share -->
		</aside><!-- .custom-posts-post-meta -->

		<section class="custom-posts-post-content cell large-8 large-offset-1">
			<?php
			the_content();
			?>
		</section><!-- .custom-posts-post-content -->
	</div><!-- .grid-x -->
</article><!-- #custom-posts-post-<?php the_ID(); ?> -->
