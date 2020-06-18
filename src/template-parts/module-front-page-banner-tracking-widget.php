<?php
/**
 * Front Page Banner Tracking Widget Module
 *
 * Module template for displaying the front page banner tracking widget (src).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

$title       = ( get_field( 'title' ) ) ?: '';
$description = ( get_field( 'description' ) ) ?: '';
$platforms   = ( get_field( 'platforms' ) ) ?: array(
	'platform_a' => array(
		'name'     => '',
		'post_url' => '',
		'inputs'   => array(
			'name_0' => '',
			'name_1' => '',
		),
	),
	'platform_b' => array(
		'name'     => '',
		'post_url' => '',
		'inputs'   => array(
			'name_0' => '',
			'name_1' => '',
		),
	),
	'platform_c' => array(
		'name'     => '',
		'post_url' => '',
		'inputs'   => array(
			'name_0' => '',
			'name_1' => '',
		),
	),
);
$cta_i       = ( get_field( 'cta_i' ) ) ?: array(
	'label'  => '',
	'url'    => '',
	'target' => '_self',
);
$cta_ii      = ( get_field( 'cta_ii' ) ) ?: array(
	'label'  => '',
	'url'    => '',
	'target' => '_self',
);
?>

<aside class="module-front-page-banner-tracking-widget">
	<form id="module-front-page-banner-tracking-widget-form">

		<h5 class="module-front-page-banner-tracking-widget-title">
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
		</h5><!-- .module-front-page-banner-tracking-widget-title -->

		<p class="module-front-page-banner-tracking-widget-description">
			<?php
			echo wp_kses(
				$description,
				array(
					'br' => array(
						'class' => array(),
					),
				)
			);
			?>
		</p><!-- .module-front-page-banner-tracking-widget-descripton -->

		<p class="form-field">
			<select id="module-front-page-banner-tracking-widget-form-select">
				<option value=""><?php esc_html_e( 'Select Your Platform', 'enterprise-site' ); ?></option>

				<?php
				foreach ( $platforms as $platform ) {
					$name  = ( $platform['name'] ) ?: '';
					$value = ( $platform['name'] )
						? strtolower( preg_replace( '/ /', '_', $platform['name'] ) )
						: '';

					$input0 = ( isset( $platform['inputs']['name_0'] ) )
						? array(
							'name'        => ( $platform['inputs']['name_0'] ) ?: '',
							'placeholder' => ( $platform['inputs']['placeholder_0'] ),
						)
						: false;

					$input1 = ( isset( $platform['inputs']['name_1'] ) )
						? array(
							'name'        => ( $platform['inputs']['name_1'] ) ?: '',
							'placeholder' => ( $platform['inputs']['placeholder_1'] ),
						)
						: false;

					$data_input_values = array(
						'url'    => $platform['post_url'],
						'inputs' => array(),
					);

					// Set data input values for input 0
					if ( $input0 ) {
						$data_input_values['inputs']['input0'] = $input0;
					}

					// Set data input values for input 1 (if needed)
					if ( $input1 ) {
						$data_input_values['inputs']['input1'] = $input1;
					}

					$data_input_values_json = wp_json_encode( $data_input_values );
					?>
					<option 
						value="<?php echo esc_attr( $value ); ?>"
						data-input-values="<?php echo esc_attr( $data_input_values_json ); ?>">
						<?php echo esc_html( $name ); ?>
					</option>
					<?php
				}
				?>
			</select><!-- #module-front-page-banner-tracking-widget-form-select -->

		<p class="form-field">
			<input
				type="text"
				name=""
				id="module-front-page-banner-tracking-widget-form-input1"
				disabled
			>
		</p><!-- .form-field -->

		<p class="form-field form-field-combo">
			<input
				type="text"
				name=""
				id="module-front-page-banner-tracking-widget-form-input0"
				disabled
				placeholder="<?php echo esc_attr( 'N/A', 'enterprise-site' ); ?>"
			>
			<button
				class="btn btn-primary"
				id="module-front-page-banner-tracking-widget-form-input-submit"
				disabled><?php esc_html_e( 'Track', 'enterprise-site' ); ?></button>
		</p><!-- .form-field -->
	</form><!-- #module-front-page-banner-tracking-widget-form -->

	<a
		class="module-front-page-banner-tracking-widget-cta-login module-front-page-banner-tracking-widget-cta"
		href="<?php echo esc_attr( $cta_i['url'] ); ?>"
		target="<?php echo esc_attr( $cta_i['target'] ); ?>"
	><?php echo esc_html( $cta_i['label'] ); ?></a>
	<a
		class="module-front-page-banner-tracking-widget-cta-sales-ready module-front-page-banner-tracking-widget-cta"
		href="<?php echo esc_attr( $cta_ii['url'] ); ?>"
		target="<?php echo esc_attr( $cta_ii['target'] ); ?>"
	><?php echo esc_html( $cta_ii['label'] ); ?></a>

</aside><!-- .module-front-page-banner-tracking-widget -->
