<?php
/**
 * Flexible Content Featured Posts Row
 *
 * Flexible content row layout for displaying text (src).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
if ( $visible ) {
	?>
	<section class="content-row 
	<?php
	echo esc_attr( "$content_row_class" );
	echo ' ';
	echo esc_attr( "$content_row_count_class" );
	echo ' ';
	echo esc_attr( "$padding" );
	echo ' ';
	echo esc_attr( "$background_color" );
	?>
	">
		<div class="grid-container">
			<?php
			if ( $title ) {
				?>
				<div class="grid-x grid-margin-x">
					<div class="cell medium-6 medium-offset-3">
						<h2 class="content-row-title">
							<?php
							echo wp_kses(
								$title,
								array(
									'br' => array(),
								)
							);
							?>
						</h2><!-- .content-row-title -->
					</div><!-- .cell -->
				</div><!-- .grid-x -->
				<?php
			}

			if ( $description ) {
				?>
				<div class="grid-x grid-margin-x">
					<div class="cell large-6 large-offset-3 medium-8 medium-offset-2">
						<h4 class="content-row-description">
							<?php
							echo wp_kses(
								$description,
								array(
									'br' => array(),
								)
							);
							?>
						</h4><!-- .content-row-description -->
					</div><!-- .cell -->
				</div><!-- .grid-x -->
				<?php
			}

			$post_selection_type = ( get_sub_field( 'selection_type' ) ) ?: 'dynamic';
			$post_type           = ( get_sub_field( 'post_type' ) ) ?: array( 'news', 'resources' );

			// Set our manual/dynamic posts pool.
			$posts_manual  = ( ( 'manual' === $post_selection_type ) && get_sub_field( 'posts' ) )
				? get_sub_field( 'posts' )
				: array();
			$posts_dynamic = array();

			if ( count( $posts_manual ) < 3 ) {

				$args = array(
					'no_found_rows'          => true,
					'orderby'                => 'rand',
					'posts_per_page'         => 3,
					'post_type'              => $post_type,
					'post_status'            => array( 'publish' ),
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
				);

				$posts_dynamic_query = new WP_Query( $args );
				$count               = count( $posts_manual );

				/* Grab n posts equal to 3 minus the number of posts which
				 * have been selected manually.
				 */
				if ( $posts_dynamic_query->have_posts() ) {
					while ( $posts_dynamic_query->have_posts() && $count < 3 ) {
						$posts_dynamic_query->the_post();
						if ( in_array( get_the_ID(), $posts_manual, true ) ) {
							continue;
						} else {
							$posts_dynamic[] = get_the_ID();
							$count++;
						}
					}
				}

				wp_reset_postdata();
			}

			$posts = array_merge( $posts_manual, $posts_dynamic );

			if ( $posts ) {
				?>
				<div
					class="content-row-featured-posts-outer-container"
					data-equalizer="post"
					data-equalizer-on="medium"
					data-equalize-by-row="true"
				>
					<div
						class="content-row-featured-posts-inner-container-"
						data-equalizer="title"
						data-equalizer-on="medium"
						data-equalize-by-row="true"
					>
						<div
							class="content-row-featured-posts grid-x grid-margin-x"
							data-equalizer="excerpt"
							data-equalizer-on="medium"
							data-equalize-by-row="true"
						>
							<?php
							foreach ( $posts as $post ) {
								setup_postdata( $post );
								?>
								<div class="content-row-featured-posts-post cell medium-4">
								<?php
								include( locate_template( '/template-parts/content-custom-posts-excerpt.php', false, false ) );
								?>
								</div>
								<?php
							}
							?>
						</div><!-- .content-row-featured-posts -->
					</div><!-- .content-row-featured-posts-inner-container -->
				</div><!-- .content-row-feature-posts-outer-container -->
				<?php
				wp_reset_postdata();
			}
			?>
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
