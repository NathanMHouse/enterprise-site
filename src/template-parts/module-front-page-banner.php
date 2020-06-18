<?php
/**
 * Front Page Banner Module
 *
 * Module template for displaying the front page banner (src).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
?>
<section class="front-page-banner-container">

	<div class="front-page-banner-tracking-widget-container grid-container">
		<?php
		get_template_part( 'template-parts/module', 'front-page-banner-tracking-widget' );
		?>
	</div><!-- .front-page-banner-tracking-widget-container -->

	<div class="module-front-page-banner">
		<?php
		if ( have_rows( 'slides' ) ) {
			while ( have_rows( 'slides' ) ) {
				the_row();
				$title    = ( get_sub_field( 'title' ) ) ?: '';
				$subtitle = ( get_sub_field( 'subtitle' ) ) ?: '';
				$image    = ( get_sub_field( 'image' ) ) ?: '';
				$cta_i    = ( get_sub_field( 'cta_i' ) ) ? get_sub_field( 'cta_i' ) : array(
					'label'  => __( 'Read more', 'enterprise-site' ),
					'url'    => '',
					'style'  => 'primary',
					'target' => '_self',
				);
				$cta_ii   = ( get_sub_field( 'cta_ii' ) ) ? get_sub_field( 'cta_ii' ) : array(
					'label'  => __( 'Read more', 'enterprise-site' ),
					'url'    => '',
					'style'  => 'text',
					'target' => '_self',
				);
				$control  = ( get_sub_field( 'control' ) ) ?: array(
					'title'       => '',
					'description' => '',
				);
				?>
				<div
					class="module-front-page-banner-slide"
					data-control-title="<?php echo esc_attr( $control['title'] ); ?>"
					data-control-description="<?php echo esc_attr( $control['description'] ); ?>"
					style="background-image: url('<?php echo ( $image && isset( $image ) ) ? esc_attr( wp_get_attachment_image_src( $image, 'large' )[0] ) : ''; ?>');"
				>
					<div class="grid-container">
						<section class="module-front-page-banner-content">
							<div class="grid-x grid-margin-x">
								<div class="cell medium-7">

									<?php
									if ( $title ) {
										?>
										<h1 class="module-front-page-banner-content-title">
											<?php
											echo wp_kses(
												$title,
												array(
													'br' => array(
														'class' => array(),
													),
												)
											);
											?>
										</h1><!-- .module-front-page-banner-content-title -->
										<?php
									}

									if ( $subtitle ) {
										?>
										<h3 class="module-front-page-banner-content-subtitle">
											<?php
											echo wp_kses(
												$subtitle,
												array(
													'br' => array(
														'class' => array(),
													),
												)
											);
											?>
										</h3><!-- .module-front-page-banner-content-subtitle -->
										<?php
									}
									?>
								</div><!-- .cell -->

								<div class="cell medium-12">

									<?php
									if ( $cta_i || $cta_ii ) {
										?>
										<p class="module-front-page-banner-content-ctas">
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
														'class' => array(),
														'href' => array(),
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
														'class' => array(),
														'href' => array(),
														'target' => array(),
													),
												)
											);
											?>
										</p><!-- .module-front-page-banner-content-ctas -->
										<?php
									}
									?>
								</div><!-- .cell -->
							</div><!-- .grid-x -->
						</section><!-- .module-front-page-banner-content -->
					</div><!-- .grid-container -->

					<?php
					if ( have_rows( 'videos' ) ) {
						?>
						<video
							class="module-front-page-banner-video"
							loop="true"
							muted="true"
							autoplay="true"
							poster="<?php echo ( $image && isset( $image ) ) ? esc_attr( wp_get_attachment_image_src( $image, 'large' )[0] ) : ''; ?>"
						>
							<?php
							while ( have_rows( 'videos' ) ) {
								the_row();
								$video = ( get_sub_field( 'video' ) ) ?: '';

								if ( strpos( $video, 'webm' ) ) {
									$type = 'video/webm';
								} elseif ( strpos( $video, 'mp4' ) ) {
									$type = 'video/mp4';
								} elseif ( strpos( $video, 'ogg' ) ) {
									$type = 'video/ogg';
								} elseif ( strpos( $video, 'mov' ) ) {
									$type = 'video/quicktime';
								} else {
									$type = '';
								}
								?>
								<source
									src=""
									data-src="<?php echo esc_attr( $video ); ?>"
									type="<?php echo esc_attr( $type ); ?>"
								>
								<?php
							}
							?>
						</video><!-- .front-page-banner-video -->
						<?php
					}
					?>
				</div><!-- .front-page-banner-slide -->
				<?php
			}
		}
		?>
	</div><!-- .front-page-banner -->
</section><!-- .front-page-banner-container -->

<aside class="module-front-page-banner-controls">
	<div class="grid-container">
		<div class="grid-x">
			<?php

			// Button markup is generated by Slick.
			?>
		</div><!-- .grid-margin-x -->
	</div><!-- .grid-container -->
</aside><!-- .front-page-banner-controls -->
