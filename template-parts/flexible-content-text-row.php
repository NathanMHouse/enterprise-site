<?php
/**
 * Flexible Content Text Row
 *
 * Flexible content row layout for displaying text (dist).
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
				if ( $subtitle || $title || $content ) {
					?>
					<div class="cell medium-12">
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
					<?php
				}
				?>

			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
