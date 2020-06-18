<?php
/**
 * Flexible Content Tab Row
 *
 * Flexible content row layout for displaying tabbed content (icon and text) (dist).
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

			/* Get a count on the total number of tabs so we can hide/show the
			 * the controls only where applicable and set tabs class.
			 */
			$tab_count = count( get_sub_field( 'tabs' ) );

			$tab_tabs_class = ( 1 === $tab_count )
				? 'medium-12 content-row-tab-tabs-wo-controls'
				: 'medium-10 content-row-tab-tabs-w-controls';
			if ( have_rows( 'tabs' ) ) {
				?>
				<div class="grid-x grid-margin-x">

					<?php
					if ( 1 !== $tab_count ) {
						?>
					<div class="content-row-tab-controls cell medium-2">
					</div><!-- .content-row-tab--controls -->
						<?php
					}
					?>

					<div
						class="content-row-tab-tabs cell <?php echo esc_attr( $tab_tabs_class ); ?>"
					>
						<?php
						while ( have_rows( 'tabs' ) ) {
							the_row();
							$title = ( get_sub_field( 'tab_title' ) ) ? get_sub_field( 'tab_title' ) : '';
							?>
							<section
								class="content-row-tab-tab grid-x grid-margin-x"
								title="<?php echo esc_attr( $title ); ?>"
							>
								<?php
								$tab_item_count = count( get_sub_field( 'tab_items' ) );

								// Set index so offset only appears on first item
								$count = 1;

								while ( have_rows( 'tab_items' ) ) {
									the_row();
									$description = ( get_sub_field( 'tab_item_description' ) ) ? get_sub_field( 'tab_item_description' ) : '';
									$icon        = ( get_sub_field( 'tab_item_icon' ) ) ? get_sub_field( 'tab_item_icon' ) : '';
									$title       = ( get_sub_field( 'tab_item_title' ) ) ? get_sub_field( 'tab_item_title' ) : '';
									$cta         = ( get_sub_field( 'tab_item_cta' ) ) ? get_sub_field( 'tab_item_cta' ) : '';

									switch ( $tab_item_count ) {
										case 1:
											$tab_item_class        = 'large-4 medium-6';
											$tab_item_offset_class = ( 1 === $tab_count && 1 === $count ) ? 'large-offset-4' : '';
											break;
										case 2:
											$tab_item_class        = 'large-4 medium-6';
											$tab_item_offset_class = ( 1 === $tab_count && 1 === $count ) ? 'large-offset-2' : '';
											break;
										case 3:
											$tab_item_class        = 'large-4 medium-6';
											$tab_item_offset_class = '';
											break;
										case 4:
											$tab_item_class        = ( 1 === $tab_count ) ? 'large-3 medium-6' : 'large-4 medium-6';
											$tab_item_offset_class = '';
											break;
										default:
											$tab_item_class        = 'large-4 medium-6';
											$tab_item_offset_class = '';
											break;
									}

									$tab_item_class .= ( $icon )
										? ' content-row-tab-tab-item-w-icon'
										: ' content-row-tab-tab-item-wo-icon';
									?>

										<article
											class="content-row-tab-tab-item cell <?php echo esc_attr( "$tab_item_class $tab_item_offset_class" ); ?>"
											data-equalizer-watch="article"
										>
											<?php
											if ( $icon ) {
												?>
												<div class="content-row-tab-tab-icon">
													<?php
													if ( $icon ) {
														echo wp_kses(
															enterprise_site_build_responsive_image(
																$icon,
																'medium',
																'40px',
																array(
																	'content-row-tab-tab-icon-icon',
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
												</div><!-- .content-row-tab-tab-icon -->
												<?php
											}
											?>

											<div class="content-row-tab-tab-item-content">
												<?php
												if ( $title ) {
													?>
														<h3 class="content-row-tab-tab-item-title">
															<?php
															echo wp_kses(
																$title,
																array(
																	'br' => array(),
																)
															);
															?>
														</h3><!-- .content-row-tab-tab-item-title -->
													<?php
												}

												if ( $description ) {
													?>
													<p
														class="content-row-tab-tab-item-description"
														data-equalizer-watch="description"
													>
													<?php
													echo wp_kses(
														$description,
														array(
															'br' => array(),
														)
													);
													?>
													</p><!-- .content-row-tab-item-description -->
													<?php
												}

												if ( $cta ) {
													?>
													<a
														href="<?php echo esc_attr( $cta['url'] ); ?>"
														class="content-row-tab-tab-item-cta"
														target="<?php echo esc_attr( $cta['target'] ); ?>"><?php echo esc_html( $cta['title'] ); ?></a>
													<?php
												}
												?>

											</div><!-- .content-row-tab-tab-item-content -->
										</article><!-- .content-row-tab-tab-item -->
									<?php
									$count++;
									//var_dump( $count );
								}
								?>
							</section><!-- .content-row-tab-tab -->
							<?php
						}
						?>
					</div><!-- .content-row-tab-tabs -->
				</div><!-- .grid-x -->
				<?php
			}
			?>

		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
