<?php
/**
 * Flexible Content Testimonial Row
 *
 * Flexible content row layout for displaying testimonials (src).
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

				<?php
				if ( $image ) {
					$image_class = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'image_type' ) : '';
					?>
					<div class="content-row-testimonial-image cell large-2 large-offset-2 medium-3 medium-offset-1">
						<?php
						echo wp_kses(
							enterprise_site_build_responsive_image(
								$image,
								'thumbnail',
								'100vw',
								array(
									"content-row-testimonial-image-image $image_class",
								)
							),
							array(
								'img' => array(
									'class'  => array(),
									'src'    => array(),
									'srcset' => array(),
									'sizes'  => array(),
									'alt'    => array(),
								),
							)
						);
						?>
					</div><!-- .content-row-testimonial-image -->
					<?php
				}

				if ( $content ) {
					$details           = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'details' ) : array(
						'name'    => '',
						'title'   => '',
						'company' => '',
					);
					$testimonial_class = ( $image ) ? 'large-6 medium-7' : 'medium-8 medium-offset-2';
					?>
					<div class="content-row-testimonial-content <?php echo esc_attr( $testimonial_class ); ?>">
						<figure>
							<blockquote class="content-row-testimonial-content-testimonial">
								<main>
									<?php
									echo wp_kses(
										$content,
										array(
											'br' => array(),
										)
									);
									?>
								</main>
								<footer>
										<cite class="content-row-testimonial-content-client"><?php echo esc_html( $details['name'] ); ?>,</cite>
										<cite class="content-row-testimonial-content-title"><?php echo esc_html( $details['title'] ); ?></cite>
										<span class="hide-on-mobile"><?php esc_html_e( ' at ', 'enterprise-site' ); ?></span>
										<cite class="content-row-testimonial-content-client"><?php echo esc_html( $details['company'] ); ?></cite>
								</footer>
							</blockquote><!-- .content-row-testimonial-content-testimonial -->
						</figure>
					</div><!-- .content-row-testimonial-content -->
					<?php
				}
				?>
			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
