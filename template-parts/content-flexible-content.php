<?php
/**
 * Content Flexible Content Template
 *
 * Content template for displaying flexible content blocks (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
if ( function_exists( 'have_rows' ) ) {
	if ( have_rows( 'flexible_content' ) ) {

		$i = 0;

		while ( have_rows( 'flexible_content' ) ) {
			the_row();

			$i++;

			// Set up the generic values.
			$background_color = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'background_color' ) : '';
			$background_image = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'background_image' ) : '';
			$content          = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'content' ) : '';
			$cta_i            = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'cta_i' ) : array(
				'label'  => __( 'Read more', 'enterprise-site' ),
				'url'    => '',
				'style'  => 'primary',
				'target' => '_self',
			);
			$cta_ii           = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'cta_ii' ) : array(
				'label'  => __( 'Read more', 'enterprise-site' ),
				'url'    => '',
				'style'  => 'text',
				'target' => '_self',
			);
			$description      = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'description' ) : '';
			$image            = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'image' ) : '';
			$video            = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'video' ) : '';
			$padding          = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'padding' ) : 'padding-both';
			$subtitle         = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'subtitle' ) : '';
			$title            = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'title' ) : '';
			$visible          = ( function_exists( 'get_sub_field' ) ) ? get_sub_field( 'visible' ) : true;

			$row_layout = str_replace( '_', '-', get_row_layout() );

			$content_row_class       = ( $background_image ) ? "content-row-$row_layout content-row-background-image" : "content-row-$row_layout";
			$content_row_count_class = "content-row-$i";

			$file_path = get_template_directory() . '/template-parts/flexible-content-' . $row_layout . '.php';

			if ( file_exists( $file_path ) && is_file( $file_path ) ) {
				include $file_path;
			}
		}
	}
} else {
	?>
	<p>
		<?php
		$url = 'https://advancedcustomfields.com';
		printf(
			wp_kses(
				/* translators: 1: Advanced Custom Fields site URL. */
				__( 'This boilerplate requires <a href="%s">Advanced Custom Fields</a>. Please install and activate the plugin.', 'enterprise-site' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			),
			esc_url( $url )
		);
		?>
	</p>
	<?php
}
