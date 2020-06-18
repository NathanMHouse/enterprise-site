<?php
/**
 * Flexible Content CTA Row
 *
 * Flexible content row layout for displaying CTAs (src).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

$type = ( get_sub_field( 'type' ) ) ?: 'cta';

if ( $visible ) {
	?>
	<section
	<?php
	if ( $background_image ) {
		?>
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
		<?php
	}
	?>

	class="content-row 
	<?php
	echo esc_attr( $content_row_class );
	echo ' ';
	echo esc_attr( $content_row_count_class );
	echo ' ';
	echo esc_attr( $padding );
	echo ' ';
	echo esc_attr( $background_color );
	?>
	"
	>
		<div class="grid-container">

			<?php
			if ( $title ) {
				?>
				<div class="grid-x grid-margin-x">
					<div class="cell large-4 large-offset-4 medium-8 medium-offset-2">
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

			if ( ( 'cta' === $type ) && ( $cta_i || $cta_ii ) ) {
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
			} elseif ( 'form' === $type ) {

				$form = ( get_sub_field( 'form' ) ) ?: array(
					'post_url'        => '',
					'placeholder'     => '',
					'name'            => '',
					'button_label'    => '',
					'success_message' => '',
					'error_message'   => '',
				);
				?>
				<div class="grid-x grid-margin-x">
					<form
						id ="content-row-form"
						class="content-row-form cell medium-6 medium-offset-3"
						action="<?php echo esc_attr( $form['post_url'] ); ?>"
						data-success-message="<?php echo esc_attr( $form['success_message'] ); ?>"
						data-error-message="<?php echo esc_attr( $form['error_message'] ); ?>"
					>
						<p class="form-field form-field-combo">
							<input
								type="email"
								placeholder="<?php echo esc_attr( $form['placeholder'] ); ?>"
								name="<?php echo esc_attr( $form['name'] ); ?>"
								required
							>
							<button
								class="btn btn-primary"
							>
								<?php echo esc_html( $form['button_label'] ); ?>
							</button>

						</p><!-- .form-field -->
					</form><!-- #content-row-form -->
				</div><!-- .grid-x -->

				<?php
			}
			?>
		</div><!-- .grid-container -->
	</section><!-- .content-row -->
	<?php
}
