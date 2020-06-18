<?php
/**
 * Flexible Content Subnavigation Row
 *
 * Flexible content row layout for displaying intro content and subnavigation (src).
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
			<div class="grid-x grid-margin-x">

				<div class="cell large-3 large-offset-2 medium-4 medium-offset-1 medium-order-2">
					<nav class="content-row-subnavigation-subnav">
						<?php

						// Create subnav containing parent and its direct children.
						$pages    = array();
						$parent   = ( wp_get_post_parent_id( $post ) ) ?: $post->ID;
						$children = get_pages(
							array(
								'child_of'    => $parent,
								'parent'      => $parent,
								'post_status' => 'publish',

							)
						);
						foreach ( $children as $child ) {
							$pages[] = $child->ID;
						}
						array_unshift( $pages, $parent );
						wp_list_pages(
							array(
								'include'  => $pages,
								'title_li' => __( 'Subnavigation', 'enterprise-site' ),
							)
						);
						?>
					</nav><!-- .content-row-subnavigation -->
				</div><!-- .cell -->

				<?php
				if ( $subtitle || $title || $content ) {
					?>
					<div class="cell medium-7 medium-order-1">
						<div class="grid-x grid-margin-x">
							<div class="cell large-7 medium-12">
								<?php
								if ( $subtitle ) {
									?>
									<h3 class="content-row-subtitle">
										<?php
										echo wp_kses(
											$subtitle,
											array(
												'br' => array(),
											)
										);
										?>
									</h3><!-- .content-row-subtitle -->
									<?php
								}

								if ( $title ) {
									?>
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
									<?php
								}
								?>
							</div><!-- cell -->

							<div class="cell medium-12">
								<?php
								if ( $content ) {
									echo wp_kses_post(
										$content
									);
								}
								?>
							</div><!-- .cell -->
						</div><!-- .grid-container -->
					</div><!-- .cell -->
					<?php
				}
				?>
			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
