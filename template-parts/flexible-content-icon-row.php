<?php
/**
 * Flexible Content Icon Row
 *
 * Flexible content row layout for displaying icons (and text) (dist).
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
					<div class="cell large-4 large-offset-4 medium-6 medium-offset-3">
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
			?>

			<?php
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
			?>

			<div class="grid-x grid-margin-x data-watch-container">
				<?php
				$count = count( get_sub_field( 'icon_blocks' ) );
				if ( have_rows( 'icon_blocks' ) ) {
					switch ( $count ) {
						case 1:
							$icon_block_class        = 'medium-8';
							$icon_block_offset_class = 'medium-offset-2';
							break;
						case 2:
							$icon_block_class        = 'large-4 medium-6';
							$icon_block_offset_class = 'large-offset-2';
							break;
						case 3:
							$icon_block_class        = 'medium-4';
							$icon_block_offset_class = '';
							break;
						case 4:
							$icon_block_class        = 'large-3 medium-6';
							$icon_block_offset_class = '';
							break;
						default:
							break;
					}

					/* Track our icon block number so that the offset class is only
					 * applied a single time.
					 */
					$i = 0;

					while ( have_rows( 'icon_blocks' ) ) {
						the_row();
						$icon        = ( get_sub_field( 'icon' ) ) ? get_sub_field( 'icon' ) : '';
						$title       = ( get_sub_field( 'title' ) ) ? get_sub_field( 'title' ) : '';
						$description = ( get_sub_field( 'description' ) ) ? get_sub_field( 'description' ) : '';
						$cta_i       = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'cta_i' ) : array(
							'label'  => __( 'Read more', 'enterprise-site' ),
							'url'    => '',
							'style'  => 'primary',
							'target' => '_self',
						);
						?>

						<article class="content-row-icon-block cell  
						<?php
						if ( 0 === $i ) {
							echo esc_attr( "$icon_block_class $icon_block_offset_class" );
						} else {
							echo esc_attr( $icon_block_class );
						}
						?>
						">

							<div class="content-row-icon-block-icon">
								<?php
								if ( $icon ) {
									echo wp_kses(
										enterprise_site_build_responsive_image(
											$icon,
											'medium',
											'60px',
											array(
												'content-row-icon-block-icon-icon',
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
							</div><!-- .content-row-icon-block-icon -->

							<div class="content-row-icon-block-content ">

								<?php
								if ( $title ) {
									?>
									<h3 class="content-row-icon-block-title"><?php echo esc_html( $title ); ?></h3>
									<?php
								}

								if ( $description ) {
									?>
									<p class="content-row-icon-block-description data-watch-item">
									<?php
									echo wp_kses(
										$description,
										array(
											'br' => array(),
										)
									);
									?>
									</p><!-- .content-row-icon-block-description -->
									<?php
								}
								if ( $cta_i ) {
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
													'class' => array(),
													'href' => array(),
													'target' => array(),
												),
											)
										);
										?>
									</p><!-- .content-row-ctas -->
									<?php
								}
								?>
							</div><!-- .content-row-icon-block-content -->
						</article><!-- .content-row-icon-block -->
						<?php
						$i++;
					}
				}
				?>
			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
