<?php
/**
 * Flexible Content Media and Text Row
 *
 * Flexible content row layout for displaying media (image or video) (src).
 * and text content (src)
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
if ( $visible ) {

	// Foundation classes should be set according to media/content alignment
	$alignment = array(
		'media_class'   => ( 'media-left' === get_sub_field( 'alignment' ) ) ? 'medium-order-1' : 'medium-order-2 large-offset-1',
		'content_class' => ( 'media-left' === get_sub_field( 'alignment' ) ) ? ' medium-order-2 large-offset-1' : 'medium-order-1',
	);
	?>
	<section
		class="content-row 
		<?php
		echo esc_attr( "$content_row_class" );
		echo ' ';
		echo esc_attr( "$content_row_count_class" );
		echo ' ';
		echo esc_attr( "$padding" );
		echo ' ';
		echo esc_attr( "$background_color" );
		?>
		"
	>
		<div class="grid-container">
			<div class="grid-x grid-margin-x">

				<div class="content-row-media cell large-5 medium-6 
				<?php
				echo esc_attr( $alignment['media_class'] );
				?>
				">

					<?php
					if ( 'image' === get_sub_field( 'media_type' )
						&& $image ) {
						echo wp_kses(
							enterprise_site_build_responsive_image(
								$image,
								'full',
								'100vw',
								array(
									'content-row-media-image',
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
					} elseif ( 'video' === get_sub_field( 'media_type' )
						&& $video ) {
						$start    = ( strripos( $video, '/' ) ) ? strripos( $video, '/' ) + 1 : 0;
						$video_id = substr( $video, $start );

						/* Support Youtube and Vimeo.
						* Additional platforms can be added as needed.
						*/
						if ( strpos( $video, 'vimeo' ) ) {

							// For Vimeo, we need to request the video object
							$request = wp_remote_get(
								"http://vimeo.com/api/v2/video/$video_id.json",
								array(
									'headers' => array(
										'Accept' => 'application/vnd.vimeo.*+json;version=2.0',
									),
								)
							);
							$body    = wp_remote_retrieve_body( $request );
							$data    = json_decode( $body );

							$video_service   = 'vimeo';
							$video_image_src = $data[0]->thumbnail_large;
							$video_src       = '//vimeo.com/' . $video_id;
						} elseif ( strpos( $video, 'youtube' ) ) {
							$video_service   = 'youtube';
							$video_image_src = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
							$video_src       = '//youtube.com/watch?v=' . $video_id;
						} else {
							$video_service   = '';
							$video_image_src = '';
							$video_src       = '';
						}
						?>
						<img src="<?php echo esc_attr( $video_image_src ); ?>" class="content-row-media-video" data-fancybox-src="<?php echo esc_attr( $video_src ); ?>"> 
						<?php
					}
					?>
				</div><!-- .content-row-media -->

				<div class="content-row-content cell medium-6
				<?php
				echo esc_attr( $alignment['content_class'] );
				?>
				">
					<?php
					if ( $title ) {
						?>
						<h2 class="content-row-title">
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
						</h2><!-- .content-row-title -->
						<?php
					}

					if ( $content ) {
						echo wp_kses_post(
							$content
						);
					}

					if ( $cta_i || $cta_ii ) {
						?>
						<p class="content-row-ctas">
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
						</p><!-- .content-row-ctas -->
						<?php
					}
					?>
				</div><!-- .content-row-content -->

			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
