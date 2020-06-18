<?php
/**
 * CTA Row Module
 *
 * Module for displaying CTAs (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

?>
<section
<?php
if ( $ctas[ $cta_count ]['background_image'] ) {
	?>
	style="background:
	linear-gradient(
		rgba(0,0,0,0.8),
		rgba(0,0,0,0.8)
	),
	url(
	<?php
	echo ( is_int( $ctas[ $cta_count ]['background_image'] ) ) ? esc_attr( wp_get_attachment_image_src( $ctas[ $cta_count ]['background_image'], 'large' )[0] ) : '';
	?>
	) no-repeat 50% / cover"
	<?php
}
?>

class="module-cta-row 
<?php
echo esc_attr( 'module-cta-row-' . $cta_count );
echo ' ';
echo esc_attr( $ctas[ $cta_count ]['padding'] );
echo ' ';
echo esc_attr( $ctas[ $cta_count ]['background_color'] );
echo ' ';
echo esc_attr( ( $ctas[ $cta_count ]['background_image'] ) ? 'background-image' : '' );
?>
"
>
	<div class="grid-container">

		<?php
		if ( $ctas[ $cta_count ]['title'] ) {
			?>
			<div class="grid-x grid-margin-x">
				<div class="cell large-4 large-offset-4 medium-8 medium-offset-2">
					<h2 class="module-cta-row-title">
						<?php
						echo wp_kses(
							$ctas[ $cta_count ]['title'],
							array(
								'br' => array(),
							)
						);
						?>
					</h2><!-- .module-cta-row-title -->
				</div><!-- .cell -->
			</div><!-- .grid-x -->
			<?php
		}

		if ( $ctas[ $cta_count ]['description'] ) {
			?>
			<div class="grid-x grid-margin-x">
				<div class="cell large-6 large-offset-3 medium-10 medium-offset-1">
					<h4 class="module-cta-row-description">
						<?php
						echo wp_kses(
							$ctas[ $cta_count ]['description'],
							array(
								'br' => array(),
							)
						);
						?>
					</h4><!-- .module-cta-row-description -->
				</div><!-- .cell -->
			</div><!-- .grid-x -->
			<?php
		}

		if (
			( 'cta' === $ctas[ $cta_count ]['type'] )
			&& ( $ctas[ $cta_count ]['cta_i']
			|| $ctas[ $cta_count ]['cta_ii'] )
		) {
			?>
			<p class="module-cta-row-ctas">
				<?php
				echo wp_kses(
					enterprise_site_create_cta(
						$ctas[ $cta_count ]['cta_i']['label'],
						$ctas[ $cta_count ]['cta_i']['url'],
						$ctas[ $cta_count ]['cta_i']['style'],
						$ctas[ $cta_count ]['cta_i']['target'],
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
						$ctas[ $cta_count ]['cta_ii']['label'],
						$ctas[ $cta_count ]['cta_ii']['url'],
						$ctas[ $cta_count ]['cta_ii']['style'],
						$ctas[ $cta_count ]['cta_ii']['target'],
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
			</p><!-- .module-cta-row-ctas -->
			<?php
		} elseif ( 'form' === $ctas[ $cta_count ]['type'] ) {
			?>
			<div class="grid-x grid-margin-x">
				<form
					id ="module-cta-row-form"
					class="module-cta-row-form cell medium-6 medium-offset-3"
					action="<?php echo esc_attr( $ctas[ $cta_count ]['form']['post_url'] ); ?>"
					data-success-message="<?php echo esc_attr( $ctas[ $cta_count ]['form']['success_message'] ); ?>"
					data-error-message="<?php echo esc_attr( $ctas[ $cta_count ]['form']['error_message'] ); ?>"
				>
					<p class="form-field form-field-combo">
						<input
							type="email"
							placeholder="<?php echo esc_attr( $ctas[ $cta_count ]['form']['placeholder'] ); ?>"
							name="<?php echo esc_attr( $ctas[ $cta_count ]['form']['name'] ); ?>"
							required
						>
						<button
							class="btn btn-primary"
						>
							<?php echo esc_html( $ctas[ $cta_count ]['form']['button_label'] ); ?>
						</button>

					</p><!-- .form-field -->
				</form><!-- #module-cta-row-form -->
			</div><!-- .grid-x -->

			<?php
		}
		?>
	</div><!-- .grid-container -->
</section><!-- .module-cta-row -->
