<?php
/**
 * Image and Text Module
 *
 * Module template for displaying the image and text content (for use on non-fc pages) (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

$visible          = ( function_exists( 'get_field' ) ) ? get_field( 'visible' ) : false;
$background_color = ( function_exists( 'get_field' ) ) ? get_field( 'background_color' ) : '';
$padding          = ( function_exists( 'get_field' ) ) ? get_field( 'padding' ) : 'padding-both';
$title            = ( function_exists( 'get_field' ) ) ? get_field( 'title' ) : '';
$image            = ( function_exists( 'get_field' ) ) ? get_field( 'image' ) : '';
$content          = ( function_exists( 'get_field' ) ) ? get_field( 'content' ) : '';
$cta_i            = ( function_exists( 'get_field' ) ) ? get_field( 'cta_i' ) : array(
	'label'  => __( 'Read more', 'enterprise-site' ),
	'url'    => '',
	'style'  => 'primary',
	'target' => '_self',
);
$cta_ii           = ( function_exists( 'get_field' ) ) ? get_field( 'cta_ii' ) : array(
	'label'  => __( 'Read more', 'enterprise-site' ),
	'url'    => '',
	'style'  => 'text',
	'target' => '_self',
);

// Foundation classes should be set according to media/content alignment
$alignment = array(
	'image_class'   => ( 'image-left' === get_field( 'alignment' ) ) ? 'medium-order-1' : 'medium-order-2 large-offset-1',
	'content_class' => ( 'image-left' === get_field( 'alignment' ) ) ? ' medium-order-2 large-offset-1' : 'medium-order-1',
);
if ( $visible ) {
	?>
	<section 
		class="module-image-and-text 
		<?php
		echo esc_attr( "$padding" );
		echo ' ';
		echo esc_attr( "$background_color" );
		?>
	">
		<div class="grid-container">
			<div class="grid-x grid-margin-x">

				<div class="module-image-and-text-image cell large-5 medium-6 
				<?php
				echo esc_attr( $alignment['image_class'] );
				?>
				">

					<?php
					echo wp_kses(
						enterprise_site_build_responsive_image(
							$image,
							'full',
							'100vw',
							array()
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
				</div><!-- .module-image-and-text-image -->

				<div class="module-image-and-text-content cell medium-6
				<?php
				echo esc_attr( $alignment['content_class'] );
				?>
				">
					<?php
					if ( $title ) {
						?>
						<h2 class="module-image-and-text-content-title">
							<?php
								echo wp_kses(
									$title,
									array(
										'br' => array(),
									)
								);
							?>
						</h2><!-- .module-image-and-text-content-title -->
						<?php
					}

					if ( $content ) {
						echo wp_kses_post(
							$content
						);
					}

					if ( $cta_i || $cta_ii ) {
						?>
						<p class="module-image-and-text-content-ctas">
							<?php
							echo wp_kses(
								enterprise_site_create_cta(
									$cta_i['label'],
									$cta_i['url'],
									$cta_i['style'],
									$cta_i['target']
								),
								array(
									'a' => array(
										'class'  => array(),
										'href'   => array(),
										'target' => array(),
									),
								)
							);

							echo wp_kses(
								enterprise_site_create_cta(
									$cta_ii['label'],
									$cta_ii['url'],
									$cta_ii['style'],
									$cta_ii['target']
								),
								array(
									'a' => array(
										'class'  => array(),
										'href'   => array(),
										'target' => array(),
									),
								)
							);
							?>
						</p><!-- .module-image-and-text-content-ctas -->
						<?php
					}
					?>
				</div><!-- .module-image-and-text-content -->

			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .module-image-and-text -->
	<?php
}
