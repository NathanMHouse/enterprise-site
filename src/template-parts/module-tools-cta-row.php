<?php
/**
 * Tools CTA Row Module
 *
 * Module for displaying tools CTA (src).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
?>
<section class="module-tools-cta-row">
	<div class="grid-container">

		<div class="grid-x grid-margin-x">

			<div class="module-tools-cta-row-content cell medium-12">
				<?php
					$message = ( is_singular( 'borders' ) )
						? __( 'Looking for another border crossing?', 'enterprise-site' )
						: __( 'Looking for another location?', 'enterprise-site' );
					$label   = ( is_singular( 'borders' ) )
						? __( 'View All Borders', 'enterprise-site' )
						: __( 'View All Locations', 'enterprise-site' );
					$url     = ( is_singular( 'borders' ) )
						? '/borders'
						: '/locations';
				?>
				<h2><?php echo esc_html( $message ); ?></h2>
				<?php
				echo wp_kses(
					enterprise_site_create_cta(
						$label,
						$url,
						'primary',
						'_self'
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
			</div><!-- .module-tools-cta-row-content -->
		</div><!-- .grid-x -->
	</div><!-- .grid-container -->
</section><!-- .module-tools-cta-row -->
