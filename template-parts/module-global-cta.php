<?php
/**
 * Global CTA Module
 *
 * Module template for displaying the global CTA (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

$global_cta       = ( get_field( 'module_global_cta', 'options' ) ) ?: '';
$title            = ( $global_cta['title'] ) ?: '';
$background_image = ( $global_cta['background_image'] ) ?: '';
$description      = ( $global_cta['description'] ) ?: '';
$cta_blocks       = ( $global_cta['cta_blocks'] ) ?: '';
?>
<section
	class="module-global-cta"
	style="background:
	linear-gradient(
		rgba(0,0,0,0.8),
		rgba(0,0,0,0.8)
	), 
	url(
	<?php
	echo esc_attr( wp_get_attachment_image_src( $background_image, 'large' )[0] );
	?>
	) no-repeat 50% / cover"
>
	<div class="grid-container">

		<?php
		if ( $title ) {
			?>
			<div class="grid-x grid-margin-x">
				<div class="cell medium-6 medium-offset-3">
					<h2 class="module-global-cta-title">
						<?php
						echo wp_kses(
							$title,
							array(
								'br' => array(),
							)
						);
						?>
					</h2><!-- .module-global-cta-title -->
				</div><!-- .cell -->
			</div><!-- .grid-x -->
			<?php
		}
		?>

		<?php
		if ( $description ) {
			?>
			<div class="grid-x grid-margin-x">
				<div class="cell large-6 large-offset-3 medium-8 medium-offset-2">
					<h4 class="module-global-cta-description">
						<?php
						echo wp_kses(
							$description,
							array(
								'br' => array(),
							)
						);
						?>
					</h4><!-- .module-global-cta-description -->
				</div><!-- .cell -->
			</div><!-- .grid-x -->
			<?php
		}
		?>

		<div
			class="grid-x grid-margin-x data-watch-container"
			data-equalizer
			data-equalize-on="medium"
		>
			<?php
			$count = count( $cta_blocks );
			if ( $cta_blocks ) {
				switch ( $count ) {
					case 1:
						$cta_block_class        = 'large-4 medium-6';
						$cta_block_offset_class = 'large-offset-4 medium-offset-3';
						break;
					case 2:
						$cta_block_class        = 'large-4 medium-6';
						$cta_block_offset_class = 'large-offset-2';
						break;
					default:
						break;
				}

				/* Track our CTA block number so that the offset class is only
				 * applied a single time.
				 */
				$i = 0;

				foreach ( $cta_blocks as $cta_block ) {
					$icon        = ( $cta_block['icon'] ) ?: '';
					$title       = ( $cta_block['title'] ) ?: '';
					$description = ( $cta_block['description'] ) ?: '';
					$cta         = ( $cta_block['cta'] ) ?: '';
					?>

					<article class="cta-block cell  
					<?php
					if ( 0 === $i ) {
						echo esc_attr( "$cta_block_class $cta_block_offset_class" );
					} else {
						echo esc_attr( $cta_block_class );
					}
					?>
					">

						<div class="cta-block-icon">
							<?php
							if ( $icon ) {
								echo wp_kses(
									enterprise_site_build_responsive_image(
										$icon,
										'medium',
										'60px',
										array(
											'cta-block-icon-icon',
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
							}
							?>
						</div><!-- .cta-block-icon -->

						<div class="cta-block-content ">

							<?php
							if ( $title ) {
								?>
								<h3 class="cta-block-title"><?php echo esc_html( $title ); ?></h3>
								<?php
							}

							if ( $description ) {
								?>
								<p
									class="cta-block-description data-watch-item"
									data-equalizer-watch
									data-equalize-on="medium"
								>
								<?php
								echo wp_kses(
									$description,
									array(
										'br' => array(),
									)
								);
								?>
								</p><!-- .cta-block-description -->
								<?php
							}

							if ( $cta ) {
								echo wp_kses(
									enterprise_site_create_cta(
										$cta['label'],
										$cta['url'],
										$cta['style'],
										$cta['target']
									),
									array(
										'a' => array(
											'class'  => array(),
											'href'   => array(),
											'target' => array(),
										),
									)
								);
							}
							?>
						</div><!-- .cta-block-content -->
					</article><!-- .cta-icon-block -->
					<?php
					$i++;
				}
			}
			?>
		</div><!-- .grid-x -->
	</div><!-- .grid-container -->
</section><!-- .module-global-cta -->
